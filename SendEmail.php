<?php

#Send Emails with Microsoft Graph API - Mail SMTP Integration
#Don't forget to updat the creds for different apps and websites
#Update the Structure according to the required logics

#Author/Developer: Muhammad Salam - G-Tech Solutions, Australia
#Date: 29-Nov-2023 | 12:00PM

#Following package is must required 
use GuzzleHttp\Client;

public function send_mail(){
  #--------------------------> Parameters
  $subject = "Testign Emails";
  $recepient_email = "salamaslam.official@gmail.com";
  $content = "Email Content for body";
  #--------------------------> Parameters

  # Microsoft Graph API endpoint
  $graphApiEndpoint = "https://graph.microsoft.com/v1.0";

  #--------------------------> Update Always according to Domain
  # Application and client credentials
  $clientId = '';
  $clientSecret = '';
  $tenantId = '';
  $user_id = '';
  #--------------------------< Update Always according to Domain

  # Create a Guzzle HTTP client
  $client = new Client();

  # Get an access token
  $tokenEndpoint = "https://login.microsoftonline.com/$tenantId/oauth2/v2.0/token";
  $tokenResponse = $client->post($tokenEndpoint, [
    'form_params' => [
      'client_id' => $clientId,
      'client_secret' => $clientSecret,
      'scope' => 'https://graph.microsoft.com/.default',
      'grant_type' => 'client_credentials',
    ],
  ]);

  $accessToken = json_decode($tokenResponse->getBody())->access_token;

  # Send an email using Microsoft Graph API
  $sendEmailEndpoint = "$graphApiEndpoint/users/$user_id/sendMail";
  $sendEmailPayload = [
    'message' => [
      'subject' => $subject,
      'body' => [
        'contentType' => 'HTML',
        'content' => $content,
      ],
      'toRecipients' => [
        [
          'emailAddress' => [
            'address' => 'salam.free000@gmail.com',
            'name' => 'Dev Salam'
          ]
        ],
        [
          'emailAddress' => [
            'address' => 'salamaslam.official@gmail.com',
            'name' => 'Salam Aslam'
          ]
        ],
      ],

    ],
  ];

  try{
    $response = $client->post($sendEmailEndpoint, [
      'headers' => [
        'Authorization' => 'Bearer ' . $accessToken,
        'Accept' => 'application/json',
        'Content-Type' => 'application/json',
      ],
      'json' => $sendEmailPayload,
    ]);

    # Handle the response as needed
    return true;
  }
  catch(Exception $ex){
    # Handle the response as needed
    return false;
  }
}

send_mail();
