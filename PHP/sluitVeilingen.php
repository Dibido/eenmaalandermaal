<?php
/* This php file selects the auctions that have elapsed and sends an email to the buyer and the seller informing them. */

$QuerieInfoGeslotenVeilingen = <<<EOT
SELECT VW_voorwerpnummer AS voorwerpnummer, VW_titel AS titel, VW_hoogstebod AS verkoopprijs, BOD_gebruiker AS koper, GEB_mailbox AS email_koper, (SELECT  GEB_gebruikersnaam FROM Gebruiker WHERE GEB_gebruikersnaam = VW_verkoper) AS verkoper ,(SELECT  GEB_mailbox FROM Gebruiker WHERE GEB_gebruikersnaam = VW_verkoper) AS email_verkoper
FROM Voorwerp   INNER JOIN BOD
                ON Voorwerp.VW_voorwerpnummer = Bod.BOD_voorwerpnummer
                  INNER JOIN Gebruiker
                  ON Bod.BOD_gebruiker = Gebruiker.GEB_gebruikersnaam
WHERE VW_looptijdEinde < GETDATE() AND VW_hoogstebod > Voorwerp.VW_startprijs AND BOD_bodbedrag = VW_hoogstebod AND VW_veilinggesloten = 0
EOT;

function GetClosedAuctionInfo()
{
    GLOBAL $connection;
    GLOBAL $QuerieInfoGeslotenVeilingen;

    $stmt = $connection->prepare($QuerieInfoGeslotenVeilingen);
    $stmt->execute();
    return $stmt->fetchAll();
}

$info = GetClosedAuctionInfo();


foreach ($info as $GeslotenVeiling) {

    $voorwerpnummer = $GeslotenVeiling['voorwerpnummer'];
    $titel = $GeslotenVeiling['titel'];
    $verkoopprijs = $GeslotenVeiling['verkoopprijs'];
    $koper = $GeslotenVeiling['koper'];
    $email_koper = $GeslotenVeiling['email_koper'];
    $verkoper = $GeslotenVeiling['verkoper'];
    $email_verkoper = $GeslotenVeiling['email_verkoper'];


    /* -------------------------------------
                   MAIL NAAR KOPER
                ------------------------------------- */

    // Mail Headers
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= 'From: info@iproject3.icasites.nl' . "\r\n";
    $subject = 'U heeft een veiling gewonnen!';
    $message = 'test';

    $message = '
<!DOCTYPE html><html><head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"><meta name="viewport" content="width=device-width">
    
    <title>Veiling gewonnen!</title>
    <style type="text/css">
            /* -------------------------------------
                RESPONSIVE AND MOBILE FRIENDLY STYLES
            ------------------------------------- */
            @media only screen and (max-width: 620px) {
              table[class=body] h1 {
                font-size: 28px !important;
                margin-bottom: 10px !important; }
              table[class=body] p,
              table[class=body] ul,
              table[class=body] ol,
              table[class=body] td,
              table[class=body] span,
              table[class=body] a {
                font-size: 16px !important; }
              table[class=body] .wrapper,
              table[class=body] .article {
                padding: 10px !important; }
              table[class=body] .content {
                padding: 0 !important; }
              table[class=body] .container {
                padding: 0 !important;
                width: 100% !important; }
              table[class=body] .main {
                border-left-width: 0 !important;
                border-radius: 0 !important;
                border-right-width: 0 !important; }
              table[class=body] .btn table {
                width: 100% !important; }
              table[class=body] .btn a {
                width: 100% !important; }
              table[class=body] .img-responsive {
                height: auto !important;
                max-width: 100% !important;
                width: auto !important; }}
            /* -------------------------------------
              HEAD STYLES
            ------------------------------------- */
            @media all {
              .ExternalClass {
                width: 100%; }
              .ExternalClass,
              .ExternalClass p,
              .ExternalClass span,
              .ExternalClass font,
              .ExternalClass td,
              .ExternalClass div {
                line-height: 100%; }
              .apple-link a {
                color: inherit !important;
                font-family: inherit !important;
                font-size: inherit !important;
                font-weight: inherit !important;
                line-height: inherit !important;
                text-decoration: none !important; }
              .btn-primary table td:hover {
                background-color: #35316f !important; }
              .btn-primary a:hover {
                background-color: #35316f !important;
                border-color: #35316f !important; } }
    </style>
  </head>
  <body class="" style="background-color:#f6f6f6;font-family:sans-serif;-webkit-font-smoothing:antialiased;font-size:14px;line-height:1.4;margin:0;padding:0;-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;">
    <table border="0" cellpadding="0" cellspacing="0" class="body" style="border-collapse:separate;mso-table-lspace:0pt;mso-table-rspace:0pt;background-color:#f6f6f6;width:100%;">
      <tr>
        <td style="font-family:sans-serif;font-size:14px;vertical-align:top;">&nbsp;</td>
        <td class="container" style="font-family:sans-serif;font-size:14px;vertical-align:top;display:block;max-width:580px;padding:10px;width:580px;Margin:0 auto !important;">
          <div class="content" style="box-sizing:border-box;display:block;Margin:0 auto;max-width:580px;padding:10px;">
            <!-- START CENTERED WHITE CONTAINER -->
            <table class="main" style="border-collapse:separate;mso-table-lspace:0pt;mso-table-rspace:0pt;background:#fff;border-radius:3px;width:100%;">
              <!-- START MAIN CONTENT AREA -->
              <div style="background-color: #f6d155">
                <tr>
                </tr>
                <tr>
                  <td align="center" style="font-family:sans-serif;font-size:14px;vertical-align:top;background-color: #f6d155;">
                    <a href="http://iproject3.icasites.nl/" style="color:#413b88;text-decoration:underline;">
                      <img src="http://iproject3.icasites.nl/images/testlogo.png" alt="EenmaalAndermaal Logo" height="70" width="auto" style="border:none;-ms-interpolation-mode:bicubic;max-width:100%;margin:15px;">
                    </a>
                  </td>
                </tr>
              </div>
              <td class="wrapper" style="font-family:sans-serif;font-size:14px;vertical-align:top;box-sizing:border-box;padding:20px;">
                <table border="0" cellpadding="0" cellspacing="0" style="border-collapse:separate;mso-table-lspace:0pt;mso-table-rspace:0pt;width:100%;">
                  <tr>
                    <p style="font-family:sans-serif;font-size:14px;font-weight:normal;margin:0;Margin-bottom:15px;">Beste gebruiker,</p>
                    <p style="font-family:sans-serif;font-size:14px;font-weight:normal;margin:0;Margin-bottom:15px;">U heeft de veiling met de titel: <b> ' . $titel . ' </b> gewonnen!</p>
                    <p style="font-family:sans-serif;font-size:14px;font-weight:normal;margin:0;Margin-bottom:15px;">U heeft voor dit object €<b> ' . $verkoopprijs . ' </b> betaald.</p>
                  </tr>
                </table>
                <p style="font-family:sans-serif;font-size:14px;font-weight:normal;margin:0;Margin-bottom:15px;">Klik op de knop om de veiling te bekijken.</p>
                <table border="0" cellpadding="0" cellspacing="0" class="btn btn-primary" style="border-collapse:separate;mso-table-lspace:0pt;mso-table-rspace:0pt;box-sizing:border-box;width:100%;">
                  <tbody>
                    <tr>
                      <td align="left" style="font-family:sans-serif;font-size:14px;vertical-align:top;padding-bottom:15px;">
                        <table border="0" cellpadding="0" cellspacing="0" style="border-collapse:separate;mso-table-lspace:0pt;mso-table-rspace:0pt;width:100%;width:auto;">
                          <tbody>
                           <tr>
                              <td style="font-family:sans-serif;font-size:14px;vertical-align:top;background-color:#ffffff;border-radius:5px;text-align:center;background-color:#413b88;"> <a href="http://iproject3.icasites.nl/voorwerp.php?ItemID=' . $voorwerpnummer . ' " target="_blank" style="text-decoration:underline;background-color:#ffffff;border:solid 1px #413b88;border-radius:5px;box-sizing:border-box;color:#413b88;cursor:pointer;display:inline-block;font-size:14px;font-weight:bold;margin:0;padding:12px 25px;text-decoration:none;text-transform:capitalize;background-color:#413b88;border-color:#413b88;color:#ffffff;">Bekijken</a>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </td>
                    </tr>
                    <tr>
                      <td style="font-family:sans-serif;font-size:14px;vertical-align:top;padding-bottom:15px;">
                        <p style="font-family:sans-serif;font-size:14px;font-weight:normal;margin:0;Margin-bottom:15px;">Met vriendelijke groet,</p>
                        <p style="font-family:sans-serif;font-size:14px;font-weight:normal;margin:0;Margin-bottom:15px;">Het EenmaalAndermaal Team</p>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </td>
              <!-- END MAIN CONTENT AREA -->
            </table>
            <!-- START FOOTER -->
            <div class="footer" style="clear:both;padding-top:10px;text-align:center;width:100%;background-color: #444;">
              <table border="0" cellpadding="0" cellspacing="0" style="border-collapse:separate;mso-table-lspace:0pt;mso-table-rspace:0pt;width:100%;">
                <tr>
                  <td class="content-block" style="font-family:sans-serif;font-size:14px;vertical-align:top;color:#fff;font-size:12px;text-align:center; margin-bottom:10px color: #f0f0f0;">
                    <span class="apple-link" style="color:#fff;font-size:12px;text-align:center;"><a href="http://iproject3.icasites.nl/" style="color:#413b88;text-decoration:underline;color:#fff;font-size:12px;text-align:center;"><u>EenmaalAndermaal B.V.</u></a></span>
                    <br>
                    <p style="font-family:sans-serif;font-size:14px;font-weight:normal;margin:0;Margin-bottom:15px;color:#fff;font-size:12px;text-align:center;">KVK-nummer: 09091785</p>
                  </td>
                </tr>
                <tr>
                  <td style="font-family:sans-serif;font-size:14px;vertical-align:top;color:#fff;font-size:12px;text-align:center;">
                    Powered by Groep 3
                  </td>
                </tr>
              </table>
            </div>
            <!-- END FOOTER -->
            <!-- END CENTERED WHITE CONTAINER -->
          </div>
        </td>
        <td style="font-family:sans-serif;font-size:14px;vertical-align:top;">&nbsp;</td>
      </tr>
    </table>
  </body>
</html>
';

    mail($email_koper, $subject, $message, $headers);


    /* -------------------------------------
                   EINDE MAIL NAAR KOPER
                ------------------------------------- */


    /* -------------------------------------
                   MAIL NAAR VERKOPER
                ------------------------------------- */


    // Mail Headers
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= 'From: info@iproject3.icasites.nl' . "\r\n";
    $subject = 'Een van uw veilingen is succesvol verkocht!';
    $message = '
<!DOCTYPE html><html><head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"><meta name="viewport" content="width=device-width">
    
    <title>Veiling gewonnen!</title>
    <style type="text/css">
            /* -------------------------------------
                RESPONSIVE AND MOBILE FRIENDLY STYLES
            ------------------------------------- */
            @media only screen and (max-width: 620px) {
              table[class=body] h1 {
                font-size: 28px !important;
                margin-bottom: 10px !important; }
              table[class=body] p,
              table[class=body] ul,
              table[class=body] ol,
              table[class=body] td,
              table[class=body] span,
              table[class=body] a {
                font-size: 16px !important; }
              table[class=body] .wrapper,
              table[class=body] .article {
                padding: 10px !important; }
              table[class=body] .content {
                padding: 0 !important; }
              table[class=body] .container {
                padding: 0 !important;
                width: 100% !important; }
              table[class=body] .main {
                border-left-width: 0 !important;
                border-radius: 0 !important;
                border-right-width: 0 !important; }
              table[class=body] .btn table {
                width: 100% !important; }
              table[class=body] .btn a {
                width: 100% !important; }
              table[class=body] .img-responsive {
                height: auto !important;
                max-width: 100% !important;
                width: auto !important; }}
            /* -------------------------------------
              HEAD STYLES
            ------------------------------------- */
            @media all {
              .ExternalClass {
                width: 100%; }
              .ExternalClass,
              .ExternalClass p,
              .ExternalClass span,
              .ExternalClass font,
              .ExternalClass td,
              .ExternalClass div {
                line-height: 100%; }
              .apple-link a {
                color: inherit !important;
                font-family: inherit !important;
                font-size: inherit !important;
                font-weight: inherit !important;
                line-height: inherit !important;
                text-decoration: none !important; }
              .btn-primary table td:hover {
                background-color: #35316f !important; }
              .btn-primary a:hover {
                background-color: #35316f !important;
                border-color: #35316f !important; } }
    </style>
  </head>
  <body class="" style="background-color:#f6f6f6;font-family:sans-serif;-webkit-font-smoothing:antialiased;font-size:14px;line-height:1.4;margin:0;padding:0;-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;">
    <table border="0" cellpadding="0" cellspacing="0" class="body" style="border-collapse:separate;mso-table-lspace:0pt;mso-table-rspace:0pt;background-color:#f6f6f6;width:100%;">
      <tr>
        <td style="font-family:sans-serif;font-size:14px;vertical-align:top;">&nbsp;</td>
        <td class="container" style="font-family:sans-serif;font-size:14px;vertical-align:top;display:block;max-width:580px;padding:10px;width:580px;Margin:0 auto !important;">
          <div class="content" style="box-sizing:border-box;display:block;Margin:0 auto;max-width:580px;padding:10px;">
            <!-- START CENTERED WHITE CONTAINER -->
            <table class="main" style="border-collapse:separate;mso-table-lspace:0pt;mso-table-rspace:0pt;background:#fff;border-radius:3px;width:100%;">
              <!-- START MAIN CONTENT AREA -->
              <div style="background-color: #f6d155">
                <tr>
                </tr>
                <tr>
                  <td align="center" style="font-family:sans-serif;font-size:14px;vertical-align:top;background-color: #f6d155;">
                    <a href="http://iproject3.icasites.nl/" style="color:#413b88;text-decoration:underline;">
                      <img src="http://iproject3.icasites.nl/images/testlogo.png" alt="EenmaalAndermaal Logo" height="70" width="auto" style="border:none;-ms-interpolation-mode:bicubic;max-width:100%;margin:15px;">
                    </a>
                  </td>
                </tr>
              </div>
              <td class="wrapper" style="font-family:sans-serif;font-size:14px;vertical-align:top;box-sizing:border-box;padding:20px;">
                <table border="0" cellpadding="0" cellspacing="0" style="border-collapse:separate;mso-table-lspace:0pt;mso-table-rspace:0pt;width:100%;">
                  <tr>
                    <p style="font-family:sans-serif;font-size:14px;font-weight:normal;margin:0;Margin-bottom:15px;">Beste verkoper,</p>
                    <p style="font-family:sans-serif;font-size:14px;font-weight:normal;margin:0;Margin-bottom:15px;">Uw veiling met de titel: <b> ' . $titel . ' </b> is verkocht aan gebruiker <b> ' . $koper . ' </b> voor  €<b> ' . $verkoopprijs . ' </b>!</p>
                  </tr>
                </table>
                <p style="font-family:sans-serif;font-size:14px;font-weight:normal;margin:0;Margin-bottom:15px;">Klik op de knop om de veiling te bekijken.</p>
                <table border="0" cellpadding="0" cellspacing="0" class="btn btn-primary" style="border-collapse:separate;mso-table-lspace:0pt;mso-table-rspace:0pt;box-sizing:border-box;width:100%;">
                  <tbody>
                    <tr>
                      <td align="left" style="font-family:sans-serif;font-size:14px;vertical-align:top;padding-bottom:15px;">
                        <table border="0" cellpadding="0" cellspacing="0" style="border-collapse:separate;mso-table-lspace:0pt;mso-table-rspace:0pt;width:100%;width:auto;">
                          <tbody>
                           <tr>
                              <td style="font-family:sans-serif;font-size:14px;vertical-align:top;background-color:#ffffff;border-radius:5px;text-align:center;background-color:#413b88;"> <a href="http://iproject3.icasites.nl/voorwerp.php?ItemID=' . $voorwerpnummer . ' " target="_blank" style="text-decoration:underline;background-color:#ffffff;border:solid 1px #413b88;border-radius:5px;box-sizing:border-box;color:#413b88;cursor:pointer;display:inline-block;font-size:14px;font-weight:bold;margin:0;padding:12px 25px;text-decoration:none;text-transform:capitalize;background-color:#413b88;border-color:#413b88;color:#ffffff;">Bekijken</a>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </td>
                    </tr>
                    <tr>
                      <td style="font-family:sans-serif;font-size:14px;vertical-align:top;padding-bottom:15px;">
                        <p style="font-family:sans-serif;font-size:14px;font-weight:normal;margin:0;Margin-bottom:15px;">Met vriendelijke groet,</p>
                        <p style="font-family:sans-serif;font-size:14px;font-weight:normal;margin:0;Margin-bottom:15px;">Het EenmaalAndermaal Team</p>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </td>
              <!-- END MAIN CONTENT AREA -->
            </table>
            <!-- START FOOTER -->
            <div class="footer" style="clear:both;padding-top:10px;text-align:center;width:100%;background-color: #444;">
              <table border="0" cellpadding="0" cellspacing="0" style="border-collapse:separate;mso-table-lspace:0pt;mso-table-rspace:0pt;width:100%;">
                <tr>
                  <td class="content-block" style="font-family:sans-serif;font-size:14px;vertical-align:top;color:#fff;font-size:12px;text-align:center; margin-bottom:10px color: #f0f0f0;">
                    <span class="apple-link" style="color:#fff;font-size:12px;text-align:center;"><a href="http://iproject3.icasites.nl/" style="color:#413b88;text-decoration:underline;color:#fff;font-size:12px;text-align:center;"><u>EenmaalAndermaal B.V.</u></a></span>
                    <br>
                    <p style="font-family:sans-serif;font-size:14px;font-weight:normal;margin:0;Margin-bottom:15px;color:#fff;font-size:12px;text-align:center;">KVK-nummer: 09091785</p>
                  </td>
                </tr>
                <tr>
                  <td style="font-family:sans-serif;font-size:14px;vertical-align:top;color:#fff;font-size:12px;text-align:center;">
                    Powered by Groep 3
                  </td>
                </tr>
              </table>
            </div>
            <!-- END FOOTER -->
            <!-- END CENTERED WHITE CONTAINER -->
          </div>
        </td>
        <td style="font-family:sans-serif;font-size:14px;vertical-align:top;">&nbsp;</td>
      </tr>
    </table>
  </body>
</html>
';

    mail($email_verkoper, $subject, $message, $headers);


    /* -------------------------------------
               EINDE MAIL NAAR VERKOPER
            ------------------------------------- */

}


/* -------------------------------------
           SLUIT ALLE VERLOPEN VEILINGEN
        ------------------------------------- */

$QuerieSluitVeilingen = <<<EOT
UPDATE Voorwerp
SET VW_veilinggesloten = 1,
  VW_verkoopprijs = VW_hoogstebod,
  VW_koper = (ISNULL((select top 1 BOD_gebruiker from BOD where BOD_voorwerpnummer = VW_voorwerpnummer order by Bod.BOD_bodbedrag desc), NULL))
FROM Voorwerp
  FULL OUTER JOIN Bod
    ON Voorwerp.VW_voorwerpnummer = Bod.BOD_voorwerpnummer
WHERE VW_looptijdEinde < GETDATE() and VW_veilinggesloten != 1
EOT;

SendToDatabase($QuerieSluitVeilingen);

?>