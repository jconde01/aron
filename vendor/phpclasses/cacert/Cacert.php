<?php
/**
 * Created by PhpStorm.
 * User: vladzur
 * Date: 12-01-15
 * Time: 12:56 PM
 */

namespace Vladzur\Cacert;


class Cacert {
	/**
	 * Details of the certification authority
	 * @var array
	 */
	public $dn = array(
		'countryName' => 'CL',
		'stateOrProvinceName' => 'RM',
		'localityName' => 'Santiago',
		'organizationName' => 'CACERT',
		'organizationalUnitName' => 'CERT',
		'commonName' => 'CACERT',
		'emailAddress' => 'cacert@cacert.com'
	);

	/**
	 * Settings to generate certificates and keys
	 * @var array
	 */
	public $config = array(
		'digest_alg' => 'sha1',
		'x509_extensions' => 'v3_ca',
		'private_key_bits' => 2048,
		'private_key_tipe' => OPENSSL_KEYTYPE_RSA,
		'encrypt_key' => false
	);
	/**
	 * Communicates the messages to be displayed
	 * @param string $mensaje
	 */
	public $mensaje;

	/**
	 * Certification Authority
	 * @var array
	 */
	public $CADATA;

	/**
	 * Expiraton in days
	 * @var int
	 */
	public $expiration = 365;

	public function __construct($dn = null) {
		if (is_array($dn)) {
			$this->$dn = $dn;
		}
	}

	/**
	 * Generate the certificate of the certification authority CAcert
	 * NOTE: This should be executed only in the initial configuration
	 * @return array
	 */
	public function generateCACERT() {
		$priv_key = openssl_pkey_new($this->config);
		$csr = openssl_csr_new($this->dn, $priv_key, $this->config);
		$sscert = openssl_csr_sign($csr, null, $priv_key, $this->expiration, $this->config);
		$cert_out = '';
		$pk_out = '';
		openssl_x509_export($sscert, $cert_out);
		openssl_pkey_export($priv_key, $pk_out);
		$data = array(
			'x509' => $cert_out,
			'priv_key' => $pk_out,
			'expiration' => $this->get_expiration($this->expiration)
		);
		$this->CADATA = $data;
		return $data;
	}

	/**
	 * Calcula la fecha de expiración
	 * @param int $days
	 * @return string echa de expiración
	 */
	private function get_expiration($days) {
		return date('Y-m-d', strtotime('+ ' . $days . 'day'));
	}

	/**
	 * Generates the certificate and private key
	 * @param null $params
	 * @return array
	 */
	public function generateCert($params = null) {
		$dn = array(
			'countryName' => 'CL',
			'stateOrProvinceName' => 'RM',
			'localityName' => 'Santiago',
			'organizationName' => 'CACERT',
			'organizationalUnitName' => 'Certification',
			'commonName' => 'My Name',
			'emailAddress' => 'user@domain.com'
		);
		if (is_array($params)) {
			$dn = array_merge($dn, $params);
		}

		$priv_key = openssl_pkey_new();
		$CADATA = $this->CADATA;
		$cacert_key = $CADATA['priv_key'];
		$cacert = $CADATA['x509'];
		try {
			$csr = openssl_csr_new($dn, $priv_key, $this->config);
			$sscert = openssl_csr_sign($csr, $cacert, $cacert_key, $this->expiration, $this->config);
		} catch (Exception $e) {
			$this->mensaje = $e->getMessage();
			return false;
		}
		if (!$sscert) {
			$this->mensaje = "Error firmando el certificado";
			return false;
		}
		$cert_out = '';
		$pk_out = '';
		$x509_result = openssl_x509_export($sscert, $cert_out);
		$pkey_result = openssl_pkey_export($priv_key, $pk_out);
		if (!$x509_result) {
			$this->mensaje = "Error al exportar certificado";
			return false;
		}
		if (!$pkey_result) {
			$this->mensaje = "Error exportando la clave primaria";
			return false;
		}

		//Guardar Certificado
		$data_cert = array(
			'x509' => $cert_out,
			'expiration' => $this->get_expiration($this->expiration)
		);

		//Guardar Clave privada
		$data_pkey = array(
			'priv_key' => $pk_out
		);

		return array(
			'CERT' => $data_cert,
			'KEY' => $data_pkey
		);
	}

	/**
	 * Get public key from certificate
	 * @param $cert
	 * @return string
	 */
	public function getPubKey($cert) {
		$pubKey = '';
		$Key = openssl_pkey_get_public($cert);
		openssl_pkey_export($Key, $pubKey);
		return $pubKey;
	}
}