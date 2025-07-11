<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Email extends BaseConfig
{
    public string $fromEmail  = '';
    public string $fromName   = '';
    public string $recipients = '';

    /**
     * The "user agent"
     */
    public string $userAgent = 'Hello Shuttle';

    /**
     * The mail sending protocol: mail, sendmail, smtp
     */
    public string $protocol = 'smtp';

    /**
     * The server path to Sendmail.
     */
    public string $mailPath = '/usr/sbin/sendmail';

    /**
     * SMTP Server Address
     */
    public string $SMTPHost = "";

    /**
     * SMTP Username
     */
    public string $SMTPUser = "";

    /**
     * SMTP Password
     */
    public string $SMTPPass = "";

    /**
     * SMTP Port
     */
    public int $SMTPPort = 587;

    /**
     * SMTP Timeout (in seconds)
     */
    public int $SMTPTimeout = 5;

    /**
     * Enable persistent SMTP connections
     */
    public bool $SMTPKeepAlive = false;

    /**
     * SMTP Encryption. Either tls or ssl
     */
    public string $SMTPCrypto = 'tls';

    /**
     * Enable word-wrap
     */
    public bool $wordWrap = true;

    /**
     * Character count to wrap at
     */
    public int $wrapChars = 76;

    /**
     * Type of mail, either 'text' or 'html'
     */
    public string $mailType = 'html';

    /**
     * Character set (utf-8, iso-8859-1, etc.)
     */
    public string $charset = 'UTF-8';

    /**
     * Whether to validate the email address
     */
    public bool $validate = false;

    /**
     * Email Priority. 1 = highest. 5 = lowest. 3 = normal
     */
    public int $priority = 3;

    /**
     * Newline character. (Use “\r\n” to comply with RFC 822)
     */
    public string $CRLF = "\r\n";

    /**
     * Newline character. (Use “\r\n” to comply with RFC 822)
     */
    public string $newline = "\r\n";

    /**
     * Enable BCC Batch Mode.
     */
    public bool $BCCBatchMode = false;

    /**
     * Number of emails in each BCC batch
     */
    public int $BCCBatchSize = 200;

    /**
     * Enable notify message from server
     */
    public bool $DSN = false;

    public function __construct()
    {
        $this->SMTPHost = isset($_SERVER["CI_ENVIRONMENT"]) && $_SERVER["CI_ENVIRONMENT"] === "production"
            ? $_SERVER["PROD_MAIL_SMTP_HOST"]
            : $_SERVER["LOCALHOST_MAIL_SMTP_HOST"];

        $this->SMTPUser = isset($_SERVER["CI_ENVIRONMENT"]) && $_SERVER["CI_ENVIRONMENT"] === "production"
            ? $_SERVER["PROD_MAIL_USER"]
            : $_SERVER["LOCALHOST_MAIL_USER"];

        $this->SMTPPass = isset($_SERVER["CI_ENVIRONMENT"]) && $_SERVER["CI_ENVIRONMENT"] === "production"
            ? $_SERVER["PROD_MAIL_PASSWORD"]
            : $_SERVER["LOCALHOST_MAIL_PASSWORD"];

        $this->SMTPPort = isset($_SERVER["CI_ENVIRONMENT"]) && $_SERVER["CI_ENVIRONMENT"] === "production"
            ? $_SERVER["PROD_MAIL_PORT"]
            : $_SERVER["LOCALHOST_MAIL_PORT"];

        $this->SMTPCrypto = isset($_SERVER["CI_ENVIRONMENT"]) && $_SERVER["CI_ENVIRONMENT"] === "production"
            ? $_SERVER["PROD_MAIL_CRYPTO"]
            : $_SERVER["LOCALHOST_MAIL_CRYPTO"];
    }
}
