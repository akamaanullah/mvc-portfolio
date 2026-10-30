<?php
/**
 * Single Source of Truth for Business, Founder & Knowledge Graph Entity Data.
 * Target Entity: Amaanullah Khan - Software Developer & Systems Architect
 * Domain: https://amaanullah.com
 */

return [
    // Entity Branding
    'name'           => 'Amaanullah Khan - Software Developer',
    'brand'          => 'Amaanullah',
    'legal_name'     => 'Amaanullah Khan - Software Developer',
    'url'            => 'https://amaanullah.com',
    'canonical_url'  => 'https://amaanullah.com',
    'logo_url'       => 'https://amaanullah.com/images/logo.png',
    'profile_image'  => 'https://amaanullah.com/media/profile-poster.jpg',
    'description'    => 'Custom software developer and systems architect in Karachi specializing in PHP and Laravel. Multi-tenant CRM systems, SaaS platforms, and business automation for clients in Pakistan, the US, UK, and UAE.',
    'price_range'    => '$$',

    // Founder / Public Person Details
    'founder_name'      => 'Amaanullah Khan',
    'founder_role'      => 'Software Developer & Systems Architect',
    'founder_title'     => 'Software Developer & Systems Architect',
    'founder_current_job' => 'Team Lead & Senior Developer at Richmond Tech Group',
    'founder_alumni'    => 'Aptech Learning',
    'founder_alumni_url'=> 'https://aptech-education.com.pk',

    // Contact & NAP (Name, Address, Phone)
    'phone_display'  => '+92 319 6935307',
    'phone_raw'      => '+923196935307',
    'email'          => 'info@amaanullah.com',
    'whatsapp_url'   => 'https://api.whatsapp.com/send?phone=923196935307',

    // Social Profiles
    'github_url'     => 'https://github.com/akamaanullah',
    'linkedin_url'   => 'https://www.linkedin.com/in/akamaanullah',
    'facebook_url'   => 'https://www.facebook.com/amaanullah.dev',
    'instagram_url'  => 'https://www.instagram.com/amaanullah.dev',

    // Geographic & Location Data (GEO Metadata)
    'locality'       => 'Karachi',
    'region'         => 'Sindh',
    'country'        => 'PK',
    'country_name'   => 'Pakistan',
    'geo_region'     => 'PK-SD',
    'geo_placename'  => 'Karachi, Sindh, Pakistan',
    'latitude'       => 24.8607,
    'longitude'      => 67.0011,

    // Google Business Profile & Knowledge Graph (GEO / Entity Anchors)
    'gbp_rating'     => '4.8',
    'gbp_reviews'    => 27,
    'gbp_kgmid'      => '/g/11xyj_sq2m',
    'gbp_search_url' => 'https://www.google.com/search?kgmid=/g/11xyj_sq2m&q=Amaanullah+Khan+-+Software+Developer',
    'gbp_maps_url'   => 'https://maps.google.com/?cid=AmaanullahKhan',

    // Verified Profiles (sameAs links for Knowledge Graph & Schema.org)
    'same_as' => [
        'https://www.linkedin.com/in/akamaanullah',
        'https://github.com/akamaanullah',
        'https://www.facebook.com/amaanullah.dev',
        'https://www.instagram.com/amaanullah.dev',
        'https://www.google.com/search?kgmid=/g/11xyj_sq2m&q=Amaanullah+Khan+-+Software+Developer',
        'https://maps.google.com/?cid=AmaanullahKhan'
    ],

    // Target Service Countries (areaServed)
    'areas_served' => [
        ['@type' => 'Country', 'name' => 'Pakistan', 'identifier' => 'PK'],
        ['@type' => 'Country', 'name' => 'United States', 'identifier' => 'US'],
        ['@type' => 'Country', 'name' => 'United Kingdom', 'identifier' => 'GB'],
        ['@type' => 'Country', 'name' => 'United Arab Emirates', 'identifier' => 'AE'],
        ['@type' => 'Country', 'name' => 'Saudi Arabia', 'identifier' => 'SA'],
    ],

    // Semantic Entities for knowsAbout (with Wikidata / Wikipedia URLs for maximum AEO / AI comprehension)
    'knows_about' => [
        [
            '@type' => 'Thing',
            'name' => 'Laravel',
            'sameAs' => 'https://en.wikipedia.org/wiki/Laravel'
        ],
        [
            '@type' => 'Thing',
            'name' => 'PHP',
            'sameAs' => 'https://en.wikipedia.org/wiki/PHP'
        ],
        [
            '@type' => 'Thing',
            'name' => 'MySQL',
            'sameAs' => 'https://en.wikipedia.org/wiki/MySQL'
        ],
        [
            '@type' => 'Thing',
            'name' => 'Custom CRM Development',
            'sameAs' => 'https://en.wikipedia.org/wiki/Customer_relationship_management'
        ],
        [
            '@type' => 'Thing',
            'name' => 'Software as a Service (SaaS)',
            'sameAs' => 'https://en.wikipedia.org/wiki/Software_as_a_service'
        ],
        [
            '@type' => 'Thing',
            'name' => 'Multi-Tenant Architecture',
            'sameAs' => 'https://en.wikipedia.org/wiki/Multitenancy'
        ],
        [
            '@type' => 'Thing',
            'name' => 'Business Process Automation',
            'sameAs' => 'https://en.wikipedia.org/wiki/Business_process_automation'
        ],
        [
            '@type' => 'Thing',
            'name' => 'Flutter',
            'sameAs' => 'https://en.wikipedia.org/wiki/Flutter_(software)'
        ],
        [
            '@type' => 'Thing',
            'name' => 'REST API',
            'sameAs' => 'https://en.wikipedia.org/wiki/REST'
        ],
        [
            '@type' => 'Thing',
            'name' => 'WebSocket',
            'sameAs' => 'https://en.wikipedia.org/wiki/WebSocket'
        ],
    ]
];

