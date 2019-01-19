<?php
    
    function createxml($address) {
        $doc = new DOMDocument('1.0', 'UTF-8');
        // nous voulons un joli affichage
        $doc->formatOutput = true;
        $doc->xmlStandalone = false;

        $root = $doc->createElement('record');

        //$rootAttribute = $doc->createAttribute('xmlns:xsi');
        //$rootAttribute->value = 'http://www.w3.org/2001/XMLSchema-instance';
        //$root->appendChild($rootAttribute);

        //$rootAttribute = $doc->createAttribute('xsi:noNamespaceSchemaLocation');
        //$rootAttribute->value = 'registor.xsd';
        //$root->appendChild($rootAttribute);

        $root = $doc->appendChild($root);

        foreach ($address as $value) {
            $adr = $doc->createElement('address');

            $num = $doc->createAttribute('number');
            $street = $doc->createAttribute('street');
            $district = $doc->createAttribute('district');

            $num->value = $value[0];
            $street->value = $value[1];
            $district->value = $value[2];

            $adr->appendChild($num);
            $adr->appendChild($street);
            $adr->appendChild($district);

            $ind = $doc->createElement('indicator');
            $rad = $doc->createAttribute('radius');
            $rad->value = 100;
            $ind->appendChild($rad);

            $text = $doc->createTextNode($value[3]);
            $ind = $adr->appendChild($ind);
            $ind->appendChild($text);

            $ind2 = $doc->createElement('indicator');
            $rad2 = $doc->createAttribute('radius');
            $rad2->value = 200;
            $ind2->appendChild($rad2);

            $text2 = $doc->createTextNode($value[4]);
            $ind2 = $adr->appendChild($ind2);
            $ind2->appendChild($text2);

            $ind3 = $doc->createElement('indicator');
            $rad3 = $doc->createAttribute('radius');
            $rad3->value = 500;
            $ind3->appendChild($rad3);

            $text3 = $doc->createTextNode($value[5]);
            $ind3 = $adr->appendChild($ind3);
            $ind3->appendChild($text3);

            $adr = $root->appendChild($adr);
        }

        if(!$doc->schemaValidate('xml/registor.xsd')) {
            print 'DOMDocument::schemaValidate() Generated Errors!</n>';
        } else {
            $doc->save("xml/test.xml");
        }
    }
    
    $address = [ [ '18', 'rue Georges Bizet', '13', '1', '0.7', '0.8' ], [ '263', 'rue de Paris', '15', '0.6', '0.7', '1']];
    createxml($address);
?>