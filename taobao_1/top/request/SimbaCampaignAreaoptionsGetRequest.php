<?php
/**
 * TOP API: taobao.simba.campaign.areaoptions.get request
 * 
 * @author auto create
 * @since 1.0, 2013-03-05 16:38:33
 */
class SimbaCampaignAreaoptionsGetRequest
{
	
	private $apiParas = array();
	
	public function getApiMethodName()
	{
		return "taobao.simba.campaign.areaoptions.get";
	}
	
	public function getApiParas()
	{
		return $this->apiParas;
	}
	
	public function check()
	{
		
	}
	
	public function putOtherTextParam($key, $value) {
		$this->apiParas[$key] = $value;
		$this->$key = $value;
	}
}
