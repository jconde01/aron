# Cacert
Cacert is used to generate self-signed certificates.

You can generate the certificate of the certification authority and generate new certificates with that signature

## Usage

    <?php
    require_once 'Cacert.php';
    $CA = new \Vladzur\Cacert\Cacert();
    print_r($CA->generateCACERT()); //CA Certificate
    $params = array(
        'commonName' => 'Vladimir Zurita',
        'emailAddress' => 'vladzur@gmail.com',
        'organizationName' => 'Lemontech',
        'organizationalUnitName' => 'Developers'
    );
    print_r($CA->generateCert($params)); //USer Certificate