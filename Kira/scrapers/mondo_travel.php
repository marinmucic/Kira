<?php
function curlGet($url) {
    $ch = curl_init(); 

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);  
    curl_setopt($ch, CURLOPT_URL, $url);
    $results = curl_exec($ch); 
    curl_close($ch); 
    return $results;
    
}

function returnXPathObject($item) {
    $xmlPageDom = new DomDocument(); 
    @$xmlPageDom->loadHTML($item); 
    $xmlPageXPath = new DOMXPath($xmlPageDom); 
    return $xmlPageXPath; 
    
}

$page=curlGet('http://www.mondotravel.hr/');
//echo $page;
$XPathObject=returnXPathObject($page);

$dateArray=array();
$locationArray=array();
$hrefArray=array();


$date = $XPathObject->query('//div[@class="module-body"]/table/tbody/tr/td[1]/a[1]/span'); 
if ($date->length > 0) {
    for($i = 0; $i < $date->length; $i++) {
    
        $dateArray['date'][] = $date->item($i)->nodeValue; 
    
    }
}


$location = $XPathObject->query('//div[@class="module-body"]/table/tbody/tr/td[2]//a[1]'); 
if ($location->length > 0) {
    for($i = 0; $i < $location->length; $i++) {
    
        $locationArray['location'][] = $location->item($i)->nodeValue; 
    
    }
}


$href = $XPathObject->query('//div[@class="module-body"]/table/tbody/tr/td[2]/span/a/@href'); 
if ($href->length > 0) {
    for($i = 0; $i < $href->length; $i++) {
    
        $hrefArray['href'][] = $href->item($i)->nodeValue; 
    
    }
}

echo '<pre>';
print_r($dateArray);
print_r($locationArray);
print_r($hrefArray);
echo '</pre>';

//class=module-body




function scrapeBetween($item, $start, $end) {
    
    if (($startPos = stripos($item, $start)) === false) { 
        return false; 
    } else if (($endPos = stripos($item, $end)) === false) { 
        return false; 
    } else {
        $substrStart = $startPos + strlen($start); 
        return substr($item, $substrStart, $endPos - $substrStart);

    }
}




for($i=0;$i< 10;$i++){

$fullLink='http://www.mondotravel.hr'.$hrefArray['href'][$i];
 echo $fullLink.'<br>';  
$item=curlGet($fullLink);
//$cijena =scrapeBetween($item,'cijena',' kn');
$XPathObject=returnXPathObject($item);
$cijena =$XPathObject->query('//div[@id="page"]/hr/following::p[position()<10]');
    for($j=0;$j<$cijena->length;$j++){
        $nesto = $cijena->item($j)->nodeValue.'<br>'.$j.'<br>';
        /*
        if((strpos($nesto,'REDOVNA CIJENA')) || (strpos($nesto,'Redovna cijena')) ||  (strpos($nesto,'CIJENA ARANŽMANA'))  ){
           echo $nesto.'<br>';
        }else{
            echo 'nista<br>';
        }*/
        echo $nesto;
    }
        
sleep(rand(0,2));
    
}

?>