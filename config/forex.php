<?php

return [

    /*
    |--------------------------------------------------------------------------
    | HuggingFace API Configuration
    |--------------------------------------------------------------------------
    */
    'verify_ssl' => false,
    'huggingface_api_token' => env('HUGGINGFACE_API_TOKEN', ''),
    'huggingface_model' => env('HUGGINGFACE_MODEL', 'google/flan-t5-base'),
    'huggingface_fallback_model' => env('HUGGINGFACE_FALLBACK_MODEL', 'google/flan-t5-base'),

    /*
    |--------------------------------------------------------------------------
    | RSS Feeds — Top Forex News Sources
    |--------------------------------------------------------------------------
    */
    'rss_feeds' => [
        [
            'name' => 'ForexLive',
            'url' => 'https://www.forexlive.com/feed',
        ],
        [
            'name' => 'FXStreet',
            'url' => 'https://www.fxstreet.com/rss/news',
        ],
        [
            'name' => 'Investing.com',
            'url' => 'https://www.investing.com/rss/news_285.rss',
        ],
        [
            'name' => 'BabyPips',
            'url' => 'https://www.babypips.com/feed',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Content Settings
    |--------------------------------------------------------------------------
    */
    'posts_per_day' => env('FOREX_POSTS_PER_DAY', 10),

    /*
    |--------------------------------------------------------------------------
    | Relevance Keywords — Used to score and filter articles
    |--------------------------------------------------------------------------
    */
    'relevance_keywords' => [
        // Major pairs
        'EUR/USD', 'GBP/USD', 'USD/JPY', 'AUD/USD', 'USD/CAD', 'NZD/USD', 'USD/CHF',
        'EURUSD', 'GBPUSD', 'USDJPY', 'AUDUSD', 'USDCAD', 'NZDUSD', 'USDCHF',
        // Commodities
        'Gold', 'XAU/USD', 'XAUUSD', 'Silver', 'Oil', 'WTI', 'Brent',
        // Central banks & policy
        'Fed', 'Federal Reserve', 'ECB', 'BOE', 'BOJ', 'RBA',
        'interest rate', 'rate decision', 'rate hike', 'rate cut', 'hawkish', 'dovish',
        // Economic data
        'NFP', 'Non-Farm Payrolls', 'CPI', 'inflation', 'GDP', 'PMI',
        'employment', 'unemployment', 'retail sales', 'consumer confidence',
        // Trading
        'forex', 'currency', 'pip', 'support', 'resistance', 'breakout',
        'technical analysis', 'fundamental analysis', 'trading', 'trader',
        'bull', 'bear', 'rally', 'selloff', 'sell-off', 'volatility',
    ],

    /*
    |--------------------------------------------------------------------------
    | CTA Mapping — Keywords → Target pages on tradelikeokafor.com
    |--------------------------------------------------------------------------
    */
    'cta_mapping' => [
        'signals' => [
            'keywords' => ['EUR/USD', 'GBP/USD', 'USD/JPY', 'EURUSD', 'GBPUSD', 'currency', 'forex signal'],
            'cta' => 'Want to trade this move? Get expert forex signals and live analysis at tradelikeokafor.com/signals →',
            'url' => '/signals',
        ],
        'mentorship' => [
            'keywords' => ['strategy', 'technical analysis', 'fundamental analysis', 'trading plan', 'risk management'],
            'cta' => 'Ready to master forex trading? Join the Trade Like Okafor mentorship program and learn from a proven expert →',
            'url' => '/mentorship',
        ],
        'news_trading' => [
            'keywords' => ['NFP', 'CPI', 'GDP', 'PMI', 'employment', 'inflation', 'Non-Farm'],
            'cta' => 'Learn how to trade high-impact news events profitably. Get started with Trade Like Okafor today →',
            'url' => '/mentorship',
        ],
        'commodities' => [
            'keywords' => ['Gold', 'XAU', 'Silver', 'Oil', 'WTI', 'Brent', 'commodity'],
            'cta' => 'Trading gold and commodities? Get real-time signals and expert analysis at tradelikeokafor.com/signals →',
            'url' => '/signals',
        ],
        'default' => [
            'cta' => 'Discover more on tradelikeokafor.com',
            'keywords' => [],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Groq API Configuration
    |--------------------------------------------------------------------------
    */
    'groq_api_key' => env('GROQ_API_KEY', ''),
    'groq_model' => env('GROQ_MODEL', 'llama-3.3-70b-versatile'),

    /*
    |--------------------------------------------------------------------------
    | Hybrid fallback flag
    |--------------------------------------------------------------------------
    */
    'fallback_to_huggingface' => env('FALLBACK_TO_HUGGINGFACE', true),

    /*
    |--------------------------------------------------------------------------
    | Cleanup Settings
    |--------------------------------------------------------------------------
    */
    'raw_article_retention_days' => 30,
    'rejected_draft_retention_days' => 14,

    /*
    |--------------------------------------------------------------------------
    | Image Generation Configuration
    |--------------------------------------------------------------------------
    */
    'image_driver' => env('IMAGE_GENERATOR_DRIVER', 'pexels'),
    'pexels_api_key' => env('PEXELS_API_KEY', ''),
    'pixabay_api_key' => env('PIXABAY_API_KEY', ''),
    'unsplash_api_key' => env('UNSPLASH_API_KEY', ''),
    'siliconflow_api_key' => env('SILICONFLOW_API_KEY', ''),
    'getimg_api_key' => env('GETIMG_API_KEY', ''),

];
