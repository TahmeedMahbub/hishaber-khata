<?php

namespace App\Domains\Product\Services;

use App\Domains\Category\Models\Category;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ProductImportService
{
    /**
     * Expected header row (columns A–H). The uploaded file's first row
     * must match this EXACTLY, otherwise the import is rejected.
     *
     * @var array<int, string>
     */
    public const HEADERS = [
        'পণ্যের নাম',
        'ক্যাটাগরি (ঐচ্ছিক)',
        'বারকোড (ঐচ্ছিক)',
        'ক্রয়মূল্য',
        'বিক্রয়মূল্য',
        'একক',
        'বর্তমান স্টক',
        'কম স্টক সতর্কতা',
    ];

    public function __construct(protected ProductService $products)
    {
    }

    /**
     * Import products from an uploaded spreadsheet.
     *
     * @return array{imported:int, errors:array<int, string>}
     *
     * @throws \App\Domains\Product\Services\ProductImportException
     */
    public function import(UploadedFile $file): array
    {
        $rows = $this->readRows($file);

        if (empty($rows)) {
            throw new ProductImportException('ফাইলটি খালি। অন্তত একটি পণ্যের সারি যোগ করুন।');
        }

        // ── 1. Strict header check (first row must be unchanged) ──
        $header = array_map([$this, 'normalize'], array_slice($rows[0], 0, count(self::HEADERS)));

        if ($header !== self::HEADERS) {
            throw new ProductImportException(
                'প্রথম সারির শিরোনাম (কলামের নাম) অপরিবর্তিত রাখুন। টেমপ্লেটের শিরোনাম পরিবর্তন করা যাবে না।'
            );
        }

        // ── 2. Process data rows ──
        $imported = 0;
        $errors = [];
        $categoryCache = [];

        foreach (array_slice($rows, 1) as $index => $row) {
            $lineNo = $index + 2; // human-friendly row number (header is row 1)

            // Skip fully empty rows
            if ($this->isEmptyRow($row)) {
                continue;
            }

            $data = [
                'name'            => $this->cell($row, 0),
                'category_name'   => $this->cell($row, 1),
                'barcode'         => $this->cell($row, 2),
                'purchase_price'  => $this->number($this->cell($row, 3)),
                'sale_price'      => $this->number($this->cell($row, 4)),
                'unit'            => $this->cell($row, 5) ?: 'pcs',
                'stock_qty'       => $this->number($this->cell($row, 6)),
                'low_stock_alert' => $this->number($this->cell($row, 7)),
            ];

            $validator = Validator::make($data, [
                'name'            => ['required', 'string', 'max:150'],
                'barcode'         => ['nullable', 'string', 'max:100'],
                'unit'            => ['required', 'string', 'max:20'],
                'purchase_price'  => ['required', 'numeric', 'min:0'],
                'sale_price'      => ['required', 'numeric', 'min:0'],
                'stock_qty'       => ['required', 'numeric', 'min:0'],
                'low_stock_alert' => ['nullable', 'numeric', 'min:0'],
            ]);

            if ($validator->fails()) {
                $errors[] = "সারি {$lineNo}: " . $validator->errors()->first();

                continue;
            }

            $categoryId = $this->resolveCategoryId($data['category_name'], $categoryCache);

            $this->products->create([
                'category_id'     => $categoryId,
                'name'            => $data['name'],
                'barcode'         => $data['barcode'] ?: null,
                'unit'            => $data['unit'],
                'purchase_price'  => $data['purchase_price'],
                'sale_price'      => $data['sale_price'],
                'stock_qty'       => $data['stock_qty'],
                'low_stock_alert' => $data['low_stock_alert'],
                'status'          => 'active',
            ]);

            $imported++;
        }

        return ['imported' => $imported, 'errors' => $errors];
    }

    /**
     * Read all rows from the spreadsheet as a 0-indexed array of arrays.
     *
     * @return array<int, array<int, mixed>>
     */
    protected function readRows(UploadedFile $file): array
    {
        try {
            $reader = IOFactory::createReaderForFile($file->getRealPath());
            $reader->setReadDataOnly(true);
            $spreadsheet = $reader->load($file->getRealPath());
        } catch (\Throwable $e) {
            throw new ProductImportException('ফাইলটি পড়া যায়নি। সঠিক Excel (.xlsx) বা CSV ফাইল আপলোড করুন।');
        }

        return $spreadsheet->getActiveSheet()->toArray(null, true, false, false);
    }

    /**
     * Find an existing category by name or create it (per tenant). Cached per run.
     *
     * @param  array<string, int|null>  $cache
     */
    protected function resolveCategoryId(string $name, array &$cache): ?int
    {
        $name = trim($name);

        if ($name === '') {
            return null;
        }

        $key = mb_strtolower($name);

        if (array_key_exists($key, $cache)) {
            return $cache[$key];
        }

        $category = Category::where('name', $name)->first()
            ?? Category::create(['name' => $name, 'status' => 'active']);

        return $cache[$key] = $category->id;
    }

    /**
     * Normalize a header cell for exact comparison.
     */
    protected function normalize(mixed $value): string
    {
        return preg_replace('/\s+/u', ' ', trim((string) $value));
    }

    protected function cell(array $row, int $i): string
    {
        return trim((string) ($row[$i] ?? ''));
    }

    protected function number(string $value): float
    {
        // Convert Bengali digits to ASCII so "১২৩" parses correctly.
        $value = strtr($value, [
            '০' => '0', '১' => '1', '২' => '2', '৩' => '3', '৪' => '4',
            '৫' => '5', '৬' => '6', '৭' => '7', '৮' => '8', '৯' => '9',
        ]);

        return is_numeric($value) ? (float) $value : 0.0;
    }

    protected function isEmptyRow(array $row): bool
    {
        foreach ($row as $cell) {
            if (trim((string) $cell) !== '') {
                return false;
            }
        }

        return true;
    }
}
