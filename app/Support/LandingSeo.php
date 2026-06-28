<?php

namespace App\Support;

use Illuminate\Http\Request;

class LandingSeo
{
    public static function make(Request $request, ?string $locale = null): array
    {
        $locale = in_array($locale, ['bn', 'en'], true) ? $locale : 'bn';
        $isBangla = $locale === 'bn';
        $baseUrl = self::baseUrl($request);
        $canonical = $locale === 'en' ? "{$baseUrl}/en" : ($request->path() === 'bn' ? "{$baseUrl}/bn" : "{$baseUrl}/");
        $image = "{$baseUrl}/assets/img/project/screenshot.jpg";
        $brand = $isBangla ? 'হিসাবিজ' : 'Hishabiz';

        $title = $isBangla
            ? 'হিসাবিজ - ব্যবসার হিসাব ও স্টক ম্যানেজমেন্ট সফটওয়্যার'
            : 'Hishabiz - Accounting & Inventory Management Software Bangladesh';

        $description = $isBangla
            ? 'হিসাবিজ হলো Made for Bangladeshi Businesses ব্যবসার হিসাব সফটওয়্যার। বিক্রয়, স্টক, বাকি হিসাব, রিপোর্ট ও ইনভয়েস সহজে ম্যানেজ করুন।'
            : 'Hishabiz is easy business management software for Bangladeshi SMEs, with reliable accounting, inventory management, stock tracking, dues, invoices and reports.';

        $keywords = [
            'হিসাব সফটওয়্যার',
            'ব্যবসার হিসাব সফটওয়্যার',
            'দোকানের হিসাব সফটওয়্যার',
            'স্টক ম্যানেজমেন্ট সফটওয়্যার',
            'বাকি হিসাব সফটওয়্যার',
            'business management software',
            'inventory management software',
            'accounting software',
            'SME software Bangladesh',
            'stock management software',
            'small business software',
        ];

        $faqs = self::faqs($locale);
        $useCases = $isBangla ? [
            ['title' => 'দোকানের হিসাব সফটওয়্যার', 'text' => 'কিরানা, মুদি, ফার্মেসি, ইলেকট্রনিক্স ও ছোট দোকানের দৈনিক বিক্রয়, বাকি ও স্টক হিসাব এক জায়গায় রাখুন।'],
            ['title' => 'Inventory Management Software Bangladesh', 'text' => 'পণ্য কেনা, বিক্রয় ও লো-স্টক অ্যালার্টের মাধ্যমে স্টক ম্যানেজমেন্ট সফটওয়্যার হিসেবে ব্যবহার করুন।'],
            ['title' => 'SME Software Bangladesh', 'text' => 'বাংলাদেশি SME ব্যবসার জন্য বিক্রয়, কাস্টমার, সাপ্লায়ার, খরচ ও রিপোর্ট সহজভাবে পরিচালনা করুন।'],
        ] : [
            ['title' => 'Small Business Software', 'text' => 'Run sales, dues, stock and reporting for retail shops, pharmacies, groceries and growing SMEs from one dashboard.'],
            ['title' => 'Inventory Management Software Bangladesh', 'text' => 'Track purchases, sales, low-stock alerts and product movement with reliable inventory management software.'],
            ['title' => 'Accounting Software', 'text' => 'Manage cashbook, expenses, customer dues, supplier dues and invoices with easy business management software.'],
        ];

        $testimonials = $isBangla ? [
            ['name' => 'রহিম স্টোর', 'role' => 'মুদি দোকান', 'quote' => 'দৈনিক বিক্রয়, বাকি হিসাব ও স্টক এখন এক জায়গায় দেখা যায়।'],
            ['name' => 'নূর ফার্মেসি', 'role' => 'ফার্মেসি', 'quote' => 'মোবাইল থেকেই হিসাব আপডেট করা সহজ হয়েছে।'],
            ['name' => 'স্মার্ট ট্রেডার্স', 'role' => 'পাইকারি ব্যবসা', 'quote' => 'রিপোর্ট দেখে পণ্য কেনার সিদ্ধান্ত নিতে সুবিধা হয়।'],
        ] : [
            ['name' => 'Rahim Store', 'role' => 'Grocery shop', 'quote' => 'Sales, dues and stock are now visible in one place.'],
            ['name' => 'Noor Pharmacy', 'role' => 'Pharmacy', 'quote' => 'Updating accounts from mobile is much easier now.'],
            ['name' => 'Smart Traders', 'role' => 'Wholesale business', 'quote' => 'Reports help us make better purchase decisions.'],
        ];

        return [
            'locale' => $locale,
            'htmlLocale' => $isBangla ? 'bn-BD' : 'en-US',
            'brand' => $brand,
            'title' => $title,
            'description' => $description,
            'keywords' => implode(', ', $keywords),
            'canonical' => $canonical,
            'image' => $image,
            'alternates' => [
                'bn-BD' => "{$baseUrl}/bn",
                'en-US' => "{$baseUrl}/en",
                'x-default' => "{$baseUrl}/",
            ],
            'useCases' => $useCases,
            'testimonials' => $testimonials,
            'jsonLd' => self::jsonLd($baseUrl, $canonical, $image, $brand, $title, $description, $keywords, $faqs, $locale),
        ];
    }

    public static function sitemap(Request $request): array
    {
        $baseUrl = self::baseUrl($request);

        return [
            ['loc' => "{$baseUrl}/", 'priority' => '1.0', 'changefreq' => 'weekly'],
            ['loc' => "{$baseUrl}/bn", 'priority' => '0.9', 'changefreq' => 'weekly'],
            ['loc' => "{$baseUrl}/en", 'priority' => '0.9', 'changefreq' => 'weekly'],
            ['loc' => "{$baseUrl}/register", 'priority' => '0.6', 'changefreq' => 'monthly'],
            ['loc' => "{$baseUrl}/login", 'priority' => '0.3', 'changefreq' => 'monthly'],
        ];
    }

    private static function jsonLd(string $baseUrl, string $canonical, string $image, string $brand, string $title, string $description, array $keywords, array $faqs, string $locale): array
    {
        $faqEntities = array_map(fn ($faq) => [
            '@type' => 'Question',
            'name' => $faq['question'],
            'acceptedAnswer' => [
                '@type' => 'Answer',
                'text' => $faq['answer'],
            ],
        ], $faqs);

        return [
            [
                '@context' => 'https://schema.org',
                '@type' => 'Organization',
                '@id' => "{$baseUrl}/#organization",
                'name' => $brand,
                'url' => $baseUrl,
                'logo' => "{$baseUrl}/assets/img/project/brand-logo.svg",
                'sameAs' => [],
            ],
            [
                '@context' => 'https://schema.org',
                '@type' => 'SoftwareApplication',
                '@id' => "{$baseUrl}/#software",
                'name' => $brand,
                'applicationCategory' => 'BusinessApplication',
                'operatingSystem' => 'Web, Android, iOS',
                'url' => $canonical,
                'image' => $image,
                'description' => $description,
                'keywords' => implode(', ', $keywords),
                'inLanguage' => $locale === 'bn' ? 'bn-BD' : 'en-US',
                'offers' => [
                    '@type' => 'Offer',
                    'price' => '0',
                    'priceCurrency' => 'BDT',
                    'availability' => 'https://schema.org/InStock',
                ],
                'publisher' => [
                    '@id' => "{$baseUrl}/#organization",
                ],
            ],
            [
                '@context' => 'https://schema.org',
                '@type' => 'FAQPage',
                '@id' => "{$baseUrl}/#faq",
                'mainEntity' => $faqEntities,
            ],
            [
                '@context' => 'https://schema.org',
                '@type' => 'BreadcrumbList',
                '@id' => "{$baseUrl}/#breadcrumb",
                'itemListElement' => [
                    [
                        '@type' => 'ListItem',
                        'position' => 1,
                        'name' => $brand,
                        'item' => $baseUrl,
                    ],
                    [
                        '@type' => 'ListItem',
                        'position' => 2,
                        'name' => $title,
                        'item' => $canonical,
                    ],
                ],
            ],
            [
                '@context' => 'https://schema.org',
                '@type' => 'WebSite',
                '@id' => "{$baseUrl}/#website",
                'url' => $baseUrl,
                'name' => $brand,
                'description' => $description,
                'inLanguage' => ['bn-BD', 'en-US'],
                'publisher' => [
                    '@id' => "{$baseUrl}/#organization",
                ],
            ],
        ];
    }

    private static function baseUrl(Request $request): string
    {
        $configured = rtrim((string) config('app.url'), '/');

        if ($configured && ! str_contains($configured, 'localhost') && ! str_contains($configured, '127.0.0.1')) {
            return $configured;
        }

        $requestHost = $request->getSchemeAndHttpHost();

        if (! str_contains($requestHost, 'localhost') && ! str_contains($requestHost, '127.0.0.1')) {
            return rtrim($requestHost, '/');
        }

        return 'https://hishabiz.com';
    }

    private static function faqs(string $locale): array
    {
        $faqs = [];

        for ($i = 1; $i <= 8; $i++) {
            $question = data_get(config('translations'), "landing.faq_q{$i}.{$locale}");
            $answer = data_get(config('translations'), "landing.faq_a{$i}.{$locale}");

            if ($question && $answer) {
                $faqs[] = compact('question', 'answer');
            }
        }

        return $faqs;
    }
}
