<?php

return [

    /*
    |--------------------------------------------------------------------------
    | HuggingFace API Configuration
    |--------------------------------------------------------------------------
    */
    'huggingface_api_token' => env('HUGGINGFACE_API_TOKEN', ''),
    'huggingface_model' => env('HUGGINGFACE_MODEL', 'mistralai/Mistral-7B-Instruct-v0.3'),
    'huggingface_fallback_model' => env('HUGGINGFACE_FALLBACK_MODEL', 'meta-llama/Meta-Llama-3-8B-Instruct'),

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
        [
            'name' => 'DailyFX',
            'url' => 'https://www.dailyfx.com/feeds/all',
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
            'keywords' => [],
            'cta' => 'Start your forex trading journey with expert guidance. Visit tradelikeokafor.com and take control of your trades →',
            'url' => '/',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Cleanup Settings
    |--------------------------------------------------------------------------
    */
    'raw_article_retention_days' => 30,
    'rejected_draft_retention_days' => 14,

];
