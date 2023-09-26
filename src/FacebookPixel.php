<?php
namespace Alilor\FacebookPixel;

use Illuminate\Support\Traits\Macroable;

/**
 * Class FacebookPixel
 * @package Alilor\FacebookPixel
 */
class FacebookPixel
{
    use Macroable;
    
    /**
     * @var string
     */
    protected $pixel_ids;
    protected $enabled;
    /**
     * @var string
     */
    protected $cspNonceCallback;

    /**
     * FacebookPixel constructor.
     * @param $pixel_ids
     */
    public function __construct($pixel_ids)
    {
        $this->pixel_ids = $pixel_ids;
        $this->enabled = true;
        $this->cspNonceCallback = '';
    }
    
    /**
     * Return the Facebook Pixel id.
     *
     * @return string
     */
    public function pixel_ids()
    {
        return $this->pixel_ids;
    }
    
    /**
     * @param $pixel_ids
     * @return $this
     */
    public function setId($pixel_ids)
    {
        $this->pixel_ids = $pixel_ids;

        return $this;
    }
    
    /**
     * Enable Facebook Pixel scripts rendering.
     */
    public function enable()
    {
        $this->enabled = true;
    }
    
    /**
     * Disable Facebook Pixel scripts rendering.
     */
    public function disable()
    {
        $this->enabled = false;
    }
    
    /**
     * @return bool
     */
    public function isEnabled()
    {
        return $this->enabled;
    }

    /**
     * @return string
     */
    public function getCspNonceCallback()
    {
        return $this->cspNonceCallback;
    }

    /**
     * @param string $callback
     */
    public function addCspNonce($callback)
    {
        if (!function_exists($callback)) {
            return;
        }
        $this->cspNonceCallback = $callback;
    }
    
    /**
     * @return string
     */
    public function bodyContent()
    {
        $facebookPixelSession = session()->pull('facebookPixelSession', []);
        $pixelCode = "";
        if (count($facebookPixelSession) > 0) {
            foreach ($facebookPixelSession as $key => $facebookPixel) {
                $pixelCode .= "fbq('track', '" . $facebookPixel["name"] . "', " . json_encode($facebookPixel["parameters"]) . ");";
            };
            session()->forget('facebookPixelSession');
            if($this->cspNonceCallback) {
                return "<script nonce='" . call_user_func($this->cspNonceCallback) . "'>" . $pixelCode . "</script>";
            }
            return "<script>" . $pixelCode . "</script>";
        }
        return "";
    }
    
    /**
     * @param $eventName
     * @param array $parameters
     */
    public function createEvent($eventName, $parameters = [])
    {
        $facebookPixelSession = session('facebookPixelSession');
        $facebookPixelSession = !$facebookPixelSession ? [] : $facebookPixelSession;
        $facebookPixel = [
            "name"       => $eventName,
            "parameters" => $parameters,
        ];
        array_push($facebookPixelSession, $facebookPixel);
        session(['facebookPixelSession' => $facebookPixelSession]);
    }
}
