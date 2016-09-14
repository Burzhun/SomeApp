<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<?php
$vellummaking = 0;
	$vellumalloying = 0;
	$sizemarkup = 0;
	$moulding = 0;
	$moulding_otk = 0;
	$beforehallmarking = 0;
	$hallmarking_transport = 0;
	$hallmarking = 0;
	$polishing = 0;
	$rhodium_good = 0;
	$rhodium_work = 0;
	$waste = 0;
	$equipment = 0;
	$metal = 0;
	$stones = 0;
	$profitability = 0;
	$otk_item = 0;
	$price = 0;
	
	$velluminstall = 0;
	$iteminstall = 0;
	$stone1 = 0;
	$stone11 = 0;
	$stone12 = 0;
	$stone2 = 0;
	$stone21 = 0;
	$stone22 = 0;
	
	$pricemetal = 0;
                $pricework = 0;

	//=====================Входящие переменные==================
	 $goodkod = "0001522";
	// $goodcount = 1;
	 $goodsize = 18;
	 $stonename = "";
	//==========================================================
	
	//=====================Входящие переменные==================
	//$goodkod = $this->kod;
	$goodcount = 1; 
	//==========================================================
	
	/*if($stone==0)
	{
		$stone = $this->getDefaultStone(); 
		$stonename = $stone->name;		
	}
	else
	{
		$stone=Stone::model()->findByPk($stone); 
		$stonename = $stone->name;		
	}

	if($size==0)
	{
		$goodsize = $size;
	}
	else
	{
		$sizeModel = $this->getDefaultSize();
		$goodsize = $sizeModel->size;	
	}*/
 
	//echo "hello";
	$con = mysql_connect("localhost","agra_dbu","AopXjSGhx3y");
	mysql_select_db("agra_db");
	$sqlgood = mysql_query("select * from goods where kod = '".$goodkod."'");	
	
	$sqlsizes = mysql_query("select * from goodsize where goodkod = '".$goodkod."'");
	$countsizes = mysql_num_rows($sqlsizes);
	
	
	$sql = mysql_query("select hm.name from hallmark hm left join goods g on hm.kod = g.hallmark where g.kod = '".$goodkod."'");	
	$hallmarkname = mysql_result($sql,0,"name");
		
	$pos = strpos($hallmarkname, "Ag");
	if($pos == true)
	{
		$vellummaking = mysql_result($sqlgood, 0, "vellummaking_ag");
		$vellumalloying = mysql_result(mysql_query("select * from work where kod = '000000003'"),0,"value");
		$sizemarkup = mysql_result(mysql_query("select * from work where kod = '000000004'"),0,"value");
		$moulding = mysql_result($sqlgood, 0, "moulding_ag");
		$moulding_otk = mysql_result(mysql_query("select * from work where kod = '000000006'"),0,"value");
		$beforehallmarking = mysql_result($sqlgood, 0, "beforehallmarking_ag");
		$hallmarking_transport = mysql_result(mysql_query("select * from work where kod = '000000008'"),0,"value");
		$hallmarking = mysql_result($sqlgood, 0, "halmarking_ag");
		$polishing = mysql_result($sqlgood, 0, "polishing_ag");
		$rhodium_good = mysql_result(mysql_query("select * from work where kod = '000000012'"),0,"value");
		$rhodium_work = mysql_result($sqlgood, 0, "rhodiumplating_w_ag");
		$otk_item =  mysql_result(mysql_query("select * from work where kod = '000000014'"),0,"value");
		$waste = mysql_result(mysql_query("select * from work where kod = '000000015'"),0,"value");
		$profitability = mysql_result(mysql_query("select * from work where kod = '000000016'"),0,"value");
		$equipment = mysql_result(mysql_query("select * from work where kod = '000000017'"),0,"value");
	}
	$pos1 = strpos($hallmarkname, "Au");
	if($pos1 == true)
	{
		$vellummaking = mysql_result($sqlgood, 0, "vellummaking_au");
		$vellumalloying = mysql_result($sqlgood, 0, "vellumalloying_au");
		$sizemarkup = mysql_result(mysql_query("select * from work where kod = '000000004'"),0,"value");
		$moulding = mysql_result($sqlgood, 0, "moulding_au");
		$moulding_otk = mysql_result($sqlgood, 0, "moulding_otk_au");
		$beforehallmarking = mysql_result($sqlgood, 0, "beforehallmarking_au");
		$hallmarking_transport = mysql_result($sqlgood, 0, "hallmarkingtransport_au");
		$hallmarking = mysql_result($sqlgood, 0, "hallmarking_au");
		$polishing = mysql_result($sqlgood, 0, "polishing_au");
		$rhodium_good = mysql_result($sqlgood, 0, "rhodiumplating_m_au");
		$rhodium_work = mysql_result($sqlgood, 0, "rhodiumplating_w_au");
		$otk_item = mysql_result($sqlgood, 0 , "item_otk_au");
		$waste = mysql_result($sqlgood, 0, "waste_au");
		$profitability =mysql_result($sqlgood, 0, "rent_au");
		$equipment = mysql_result(mysql_query("select * from work where kod = '000000017'"),0,"value");
	}
	$vellummaking = $vellummaking * mysql_result($sqlgood, 0, "vellum1");
	
	if(mysql_result($sqlgood, 0, "usevellum") == 1)
	{
		$vellumalloying = $vellumalloying * $goodcount;
	}
	else
	{
		$vellumalloying = 0;
	}
		
	if($countsizes > 0)
	{
		if(mysql_result($sqlgood, 0, "goodtype") == "3")
		{
			for($i=0;$i<$countsizes;$i++)
			{
				if(mysql_result($sqlsizes, $i, "default") == 1)
				{
					$sqlgoodsize = mysql_result($sqlsizes, $i, "size");
					if($sqlgoodsize != $goodsize)
					{
						$sizemarkup = $sizemarkup;
					}
					else
					{
						$sizemarkup = 0;
					}
				}
			}
		}
	}
	else
	{
		$sizemarkup = 0;
	}
	
	$moulding = $moulding * mysql_result($sqlgood, 0, "weight_avg");
	$moulding_otk = $moulding_otk * (mysql_result($sqlgood, 0, "weight_wp")-mysql_result($sqlgood, 0, "weight_wm"));
	$beforehallmarking = $beforehallmarking * mysql_result($sqlgood, 0, "weight_bh");
	$hallmarking_transport = $hallmarking_transport * mysql_result($sqlgood, 0, "weight_avg");
	$hallmarking = $hallmarking * $goodcount;
	$polishing = $polishing * mysql_result($sqlgood, 0, "weight_ap");
	$rhodium_good = $rhodium_good * mysql_result($sqlgood, 0, "weight_ap");
	$rhodium_work = $rhodium_work * mysql_result($sqlgood, 0, "weight_ap");
	$waste = ($waste * 1.05) * mysql_result($sqlgood, 0, "weight_ap");
	$equipment = $equipment * mysql_result($sqlgood, 0, "weight_ap");
	$metal = (mysql_result($sqlgood, 0, "weight_wp")-mysql_result($sqlgood, 0, "weight_wm"))*mysql_result(mysql_query("select hm.price_gr from hallmark hm left join goods g on hm.kod = g.hallmark where g.kod = '".$goodkod."'"),0,"price_gr");
	$sqlstones = mysql_query("select * from goodstone where goodkod = '".$goodkod."'");
	$countstones = mysql_num_rows($sqlstones);
	for($i=0;$i<$countstones;$i++)
	{
		if(!mysql_result($sqlstones,$i,"can_choose") == 1)
		{
			if($pos == true)
			{
				$velluminstall = mysql_result(mysql_query("select price1 from stone where kod = '".mysql_result($sqlstones,$i,"stonekod")."'"),0,"price1");
				echo "velluminstall = ".$velluminstall;
				echo "<br>";
				$iteminstall = mysql_result(mysql_query("select price2 from stone where kod = '".mysql_result($sqlstones,$i,"stonekod")."'"),0,"price2");
				echo "iteminstall = ".$iteminstall;
				echo "<br>";
			}
			if($pos1 == true)
			{
				$velluminstall = mysql_result(mysql_query("select price3 from stone where kod = '".mysql_result($sqlstones,$i,"stonekod")."'"),0,"price3");
				echo "velluminstall = ".$velluminstall;
				echo "<br>";
				$iteminstall = mysql_result(mysql_query("select price4 from stone where kod = '".mysql_result($sqlstones,$i,"stonekod")."'"),0,"price4");
				echo "iteminstall = ".$iteminstall;
				echo "<br>";
			}
			$stone1 = $stone1 + (mysql_result(mysql_query("select cost from stone where kod = '".mysql_result($sqlstones,$i,"stonekod")."'"),0,"cost") * mysql_result($sqlstones,$i,"count"));
			echo "stone1 = ".$stone1;
			echo "<br>";
			$stone11 = $stone11 + ($velluminstall * mysql_result($sqlstones,$i,"count"));
			echo "stone11 = ".$stone11;
			echo "<br>";
			$stone12 = $stone12 + ($iteminstall * mysql_result($sqlstones,$i,"count"));
			echo "stone12 = ".$stone12;
			echo "<br>";
			
		}
		if((mysql_result($sqlstones,$i,"can_choose") == 1)&&((mysql_result($sqlstones,$i,'default') == 1)))
		//&&(mysql_result($sqlstones, $i, stonekod) == (mysql_result(mysql_query("select kod from stone where name = '".$stonename."'"),0,kod))))
		{
						if($pos == true)
			{
				$velluminstall = mysql_result(mysql_query("select price1 from stone where kod = '".mysql_result($sqlstones,$i,"stonekod")."'"),0,"price1");
				echo "velluminstall = ".$velluminstall;
				echo "<br>";
				$iteminstall = mysql_result(mysql_query("select price2 from stone where kod = '".mysql_result($sqlstones,$i,"stonekod")."'"),0,"price2");
				echo "iteminstall = ".$iteminstall;
				echo "<br>";
			}
			if($pos1 == true)
			{
				$velluminstall = mysql_result(mysql_query("select price3 from stone where kod = '".mysql_result($sqlstones,$i,"stonekod")."'"),0,"price3");
				echo "velluminstall = ".$velluminstall;
				echo "<br>";
				$iteminstall = mysql_result(mysql_query("select price4 from stone where kod = '".mysql_result($sqlstones,$i,"stonekod")."'"),0,"price4");
				echo "iteminstall = ".$iteminstall;
				echo "<br>";
			}
			$stone2 = $stone2 + (mysql_result(mysql_query("select cost from stone where kod = '".mysql_result($sqlstones,$i,"stonekod")."'"),0,"cost") * mysql_result($sqlstones,$i,"count"));
			echo "stone2 = ".$stone2;
			echo "<br>";
			$stone21 = $stone21 + ($velluminstall * mysql_result($sqlstones,$i,"count"));
			echo "stone21 = ".$stone21;
			echo "<br>";
			$stone22 = $stone22 + ($iteminstall * mysql_result($sqlstones,$i,"count"));
			echo "stone2 = ".$stone2;
			echo "<br>";
		}
	}
	
	$stones = $stone1+$stone2+$stone11+$stone12+$stone21+$stone22;
	echo "vellummaking = ".$vellummaking;
	echo "<br>";
	echo "vellumalloying = ".$vellumalloying;
	echo "<br>";
	echo "sizemarkup = ".$sizemarkup;
	echo "<br>"; 
	echo "moulding = ".$moulding;
	echo "<br>";
	echo "moulding_otk = ".$moulding_otk;
	echo "<br>";
	echo "beforehallmarking = ".$beforehallmarking;
	echo "<br>";
	echo "hallmarking_transport = ".$hallmarking_transport;
	echo "<br>";
	echo "hallmarking = ".$hallmarking;
	echo "<br>";
	echo "polishing = ".$polishing;
	echo "<br>";
	echo "rhodium_good = ".$rhodium_good;
	echo "<br>";
	echo "rhodium_work = ".$rhodium_work;
	echo "<br>";
	echo "waste = ".$waste;
	echo "<br>";
	echo "equipment = ".$equipment;
	echo "<br>";
	echo "metal = ".$metal;
	echo "<br>";
	echo "stones = ".$stones;
	echo "<br>";
	$price = 
	$vellummaking +
	$vellumalloying +
	$sizemarkup + 
	$moulding + 
	$moulding_otk +
	$beforehallmarking + 
	$hallmarking_transport +
	$hallmarking +
	$polishing +
	$rhodium_good +
	$rhodium_work +
	$waste +
	$equipment +
	$metal +
	$stones;
	
	 $pricemetal = $metal;
                $pricework = $vellummaking +
		$vellumalloying + 
		$moulding + 
		$moulding_otk +
		$beforehallmarking + 
		$hallmarking_transport +
		$hallmarking +
		$polishing +
		$rhodium_good +
		$rhodium_work;
		
		echo "<br>";
		echo "pricemetal = ".$pricemetal;
		echo "<br>";
		echo "pricework = ".$pricework;
	echo "<br>";
	echo "price = ".$price;
	echo "<br>";
echo "weight_ap = ".mysql_result($sqlgood, 0, "weight_ap");
echo "<br>";
echo "otk_item = ".$otk_item;
echo "<br>";

        $price = $price + ($otk_item*mysql_result($sqlgood, 0, "weight_ap"));
        echo "price = ".$price;
	echo "<br>";
echo "profitability = ".$profitability;
echo "<br>";
	$price = $price * (($profitability/100)+1);
	echo "price = ".$price;
	echo "<br>";

	
?>