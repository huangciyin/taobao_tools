<?php
	function getXmlData($strXml){
		$pos=strpos($strXml, 'xml');
		if ($pos) {
			# code...
			$xmlCode=simplexml_load_string($strXml,'SimpleXMLElement',LIBXML_NOCDATA);
			$arrayCode=get_object_vars_final($xmlCode);
			return $arrayCode;
		}else{
			return '';
		}
	}

	function get_object_vars_final($obj){
		if (is_object($obj)) {
			# code...
			$obj=get_object_vars($obj);
		}
		if (is_array($obj)) {
			# code...
			foreach ($obj as $key => $value) {
				# code...
				$obj[$key]=get_object_vars_final($value);
			}
		}
		return $obj;
	}
	function getDeliveryStatus($str)
	{
		if ($str=='CREATED') {
			# code...
			$getStatus="订单已创建";
		}elseif ($str=='RECREATED') {
			# code...
			$getStatus="订单重新创建";
		}elseif ($str=='CANCELLED') {
			# code...
			$getStatus="订单已取消";
		}elseif ($str=='CLOSED') {
			# code...
			$getStatus="订单关闭";
		}elseif ($str=='SENDING') {
			# code...
			$getStatus="等候发送给物流公司";
		}elseif ($str=='ACCEPTING') {
			# code...
			$getStatus="已发送给物流公司,等待接单";
		}elseif ($str=='ACCEPTED') {
			# code...
			$getStatus="物流公司已接单";
		}elseif ($str=='REJECTED') {
			# code...
			$getStatus="物流公司不接单";
		}elseif ($str=='PICK_UP') {
			# code...
			$getStatus="物流公司揽收成功";
		}elseif ($str=='PICK_UP_FAILED') {
			# code...
			$getStatus="物流公司揽收失败";
		}elseif ($str=='LOST') {
			# code...
			$getStatus="物流公司丢单";
		}elseif ($str=='REJECTED_BY_RECEIVER') {
			# code...
			$getStatus="对方拒签";
		}elseif ($str=='ACCEPTED_BY_RECEIVER') {
			# code...
			$getStatus="对方已签收";
		}
		return $getStatus;
	}
	function getOrderStatus($str){
		if ($str=='TRADE_NO_CREATE_PAY') {
			# code...
			$getOrderStatus='没有创建支付宝交易';
		}elseif ($str=='WAIT_BUYER_PAY') {
			# code...
			$getOrderStatus='等待买家付款';
		}elseif ($str=='WAIT_SELLER_SEND_GOODS') {
			# code...
			$getOrderStatus='等待卖家发货';
		}elseif ($str=='WAIT_BUYER_CONFIRM_GOODS') {
			# code...
			$getOrderStatus='卖家已发货';
		}elseif ($str=='TRADE_BUYER_SIGNED') {
			# code...
			$getOrderStatus='买家已签收';
		}elseif ($str=='TRADE_FINISHED') {
			# code...
			$getOrderStatus='交易成功';
		}elseif ($str=='TRADE_CLOSED') {
			# code...
			$getOrderStatus='退款成功,交易关闭';
		}elseif ($str=='TRADE_CLOSED_BY_TAOBAO') {
			# code...
			$getOrderStatus='卖家或买家主动关闭交易';
		}
		return $getOrderStatus;
	}

	function getRefundStatus($str){
		if ($str=='WAIT_SELLER_AGREE') {
			# code...
			$getRefundStatus='买家已经申请退款，等待卖家同意';
		}elseif ($str=='WAIT_BUYER_RETURN_GOODS') {
			# code...
			$getRefundStatus='卖家已经同意退款，等待买家退货';
		}elseif ($str=='WAIT_SELLER_CONFIRM_GOODS') {
			# code...
			$getRefundStatus='买家已经退货，等待卖家确认收货';
		}elseif ($str=='SELLER_REFUSE_BUYER') {
			# code...
			$getRefundStatus='卖家拒绝退款';
		}elseif ($str=='CLOSED') {
			# code...
			$getRefundStatus='退款关闭';
		}elseif ($str=='SUCCESS') {
			# code...
			$getRefundStatus='退款成功';
		}
		return $getRefundStatus;
	}

	function get_url_content($url){
		if (function_exists('file_get_contents')) {
			# code...
			$file_contents=file_get_contents($url);
		}else{
			$ch=curl_init();
			$timeout=5;
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
			$file_contents=curl_exec($ch);
			curl_close($ch);
		}
		 return $file_contents;
	}

?>