<?php

return [

  /*
  |--------------------------------------------------------------------------
  | Third Party Services
  |--------------------------------------------------------------------------
  |
  | This file is for storing the credentials for third party services such
  | as Mailgun, Postmark, AWS and more. This file provides the de facto
  | location for this type of information, allowing packages to have
  | a conventional file to locate the various service credentials.
  |
  */

  'postmark' => [
    'token' => env('POSTMARK_TOKEN'),
  ],

  'resend' => [
    'key' => env('RESEND_KEY'),
  ],

  'ses' => [
    'key' => env('AWS_ACCESS_KEY_ID'),
    'secret' => env('AWS_SECRET_ACCESS_KEY'),
    'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
  ],

  'slack' => [
    'notifications' => [
      'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
      'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
    ],
  ],

  'google' => [
    'client_id' => env('GOOGLE_CLIENT_ID'),
    'client_secret' => env('GOOGLE_CLIENT_SECRET'),
    'redirect' => env('GOOGLE_REDIRECT_URL'),
  ],

  'facebook' => [
    'client_id' => env('FACEBOOK_CLIENT_ID'),
    'client_secret' => env('FACEBOOK_CLIENT_SECRET'),
    'redirect' => env('FACEBOOK_REDIRECT_URI'),
    'api_version' => env('FACEBOOK_API_VERSION', 'v23.0'),
  ],

  'gemini' => [
    'api_keys' => $gemini_keys = array_filter(explode(',', env('GEMINI_API_KEYS', env('GEMINI_API_KEY', '')))),
    'api_key' => !empty($gemini_keys) ? reset($gemini_keys) : null,
  ],

  'removebg' => [
    'api_key' => env('REMOVEBG_API_KEY'),
    'api_url' => 'https://api.remove.bg/v1.0/removebg',
  ],

  'ml_microservice' => [
    'url' => env('ML_MICROSERVICE_URL', 'http://localhost:8001'),
  ],

  'serpapi' => [
    'api_key' => env('SERPAPI_API_KEY'),
    'base_url' => 'https://serpapi.com/search',
  ],
];
