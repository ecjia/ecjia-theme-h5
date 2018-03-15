<?php

class ecjia_location
{
    
    protected $mapKey;
    
    protected $mapReferer;
    
    
    public function __construct()
    {
        $this->mapKey = ecjia::config('map_qq_key');
        $this->mapReferer = ecjia::config('map_qq_referer');
    }
    
    /**
     * 获取定位地址
     * @param string $backurl
     * @return string
     */
    public function getLocationUrl($backurl)
    {
        $backurl = urlencode($backurl);
        $locationUrl = "https://apis.map.qq.com/tools/locpicker?search=1&type=0&backurl=%s&key=%s&referer=%s";
        
        return sprintf($locationUrl, $backurl, $this->mapKey, $this->mapReferer);
    }
    
    /**
     * 周边搜索（圆形范围）
     * 搜坐标位置周边1000米范围内，关键字为“城市名”
     */
    public function getNearByBoundary()
    {
        $latitude = $_COOKIE['position_latitude'];
        $longitude = $_COOKIE['position_longitude'];
        $city_name = urlencode($_COOKIE['position_city_name']);
        
        $nearByUrl = "http://apis.map.qq.com/ws/place/v1/search?boundary=nearby(%s,%s,1000)&page_size=20&page_index=1&keyword=%s&orderby=_distance&key=%s";
        $nearByUrl = sprintf($nearByUrl, $latitude, $longitude, $city_name, $this->mapKey);
        
        $response = RC_Http::remote_get($nearByUrl);
        if (is_ecjia_error($response)) return $response;
        
        $body  = json_decode($response['body'], true);
        if (empty($body['data'])) {
            $body = $this->getRegion();
        }
        
        return $body;
    }
    
    /**
     * 指定地区名称，不自动扩大范围
     * @return mixed
     */
    public function getRegionBoundary()
    {
        $city_name = urlencode($_COOKIE['position_city_name']);
        $position_name = urlencode($_COOKIE['position_name']);
        
        $regionUrl = "http://apis.map.qq.com/ws/place/v1/search?boundary=region(%s,0)&page_size=20&page_index=1&keyword=%s&orderby=_distance&key=%s";
        $regionUrl = sprintf($regionUrl, $city_name, $position_name, $this->mapKey);
        $response = RC_Http::remote_get($regionUrl);
        if (is_ecjia_error($response)) return $response;
        
        $body  = json_decode($response['body'], true);
        return $body;
    }
    
    
    public function getSuggestionRegion($region, $keywords)
    {
        $region   = urlencode($region);
        $keywords = urlencode($keywords);
        
        $url      = "http://apis.map.qq.com/ws/place/v1/suggestion/?&region_fix=1&region=%s&keyword=%s&key=%s";
        $url      = sprintf($url, $region, $keywords, $this->mapKey);
        
        $response 	= RC_Http::remote_get($url);
        if (is_ecjia_error($response)) return $response;
        
        $body  	= json_decode($response['body'], true);
        return $body;
    }
    
    
    public function getGeoCoder($latitude, $longitude)
    {
        $locations 	= $latitude . ',' . $longitude;
        $url       	= "https://apis.map.qq.com/ws/geocoder/v1/?location=%s&key=%s&get_poi=1";
        $url        = sprintf($url, $locations, $this->mapKey);
        
        $response	= RC_Http::remote_get($url);
        if (is_ecjia_error($response)) return $response;
        
        $body   	= json_decode($response['body'], true);
        return $body;
    }
    
}
