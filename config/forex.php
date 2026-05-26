<?php

return [
    // ... existing config entries ...

    // HuggingFace API Configuration
    'huggingface_api_token' => env('HUGGINGFACE_API_TOKEN', ''),
    'huggingface_model' => env('HUGGINGFACE_MODEL', 'google/flan-t5-base'),
    'huggingface_fallback_model' => env('HUGGINGFACE_FALLBACK_MODEL', 'google/flan-t5-base'),
    // Optional SSL verification flag for external calls
    'verify_ssl' => false,
    // CTA mapping configuration (can be customized in config files)
    'cta_mapping' => [
        'default' => [
            'cta' => 'Discover more on tradelikeokafor.com',
            'keywords' => [],
        ],
    ],

    // Groq API Configuration
    'groq_api_key' => env('GROQ_API_KEY', ''),
    'groq_model' => env('GROQ_MODEL', 'llama-3.3-70b-versatile'),

    // Hybrid fallback flag
    'fallback_to_huggingface' => env('FALLBACK_TO_HUGGINGFACE', true),

    // ... rest of the config (unchanged) ...
];
?>
