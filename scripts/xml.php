<?php
    
    /**
     * Créer la racine du fichier xml
     * @return DOMDoculent Le document xml.
     */
    function createxml() {
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

        return $doc;
    }
    
    /**
     * Ajoute une adresse à la liste
     * @param doc Le document xml
     * @param number Le numéro de rue
     * @param suffix Le suffix du numéro (bis, ter, ...)
     * @param street Le nom de la ruen
     * @param district L'arrondissement de l'adresse
     * @param longitude La longitude de l'adresse
     * @param latitude La latitude de l'adresse
     * @param indic100 L'indicateur pour un rayon 100
     * @param indic200 L'indicateur pour un rayon 200
     * @param indic500 L'indicateur pour un rayon 500
     * @return DOMDoculent Le document xml.
     */
    function addAddresse($doc, $number, $suffix, $street, $district, $longitude, $latitude, $indic100, $indic200, $indic500) {

            $root = $doc->documentElement;

            $adr = $doc->createElement('address');

            $num = $doc->createAttribute('number');
            $sfx = $doc->createAttribute('suffix');
            $strt = $doc->createAttribute('street');
            $dstrt = $doc->createAttribute('district');
            $lgt = $doc->createAttribute('longitude');
            $ltt = $doc->createAttribute('latitude');

            $num->value = $number;
            $sfx->value = $suffix;
            $strt->value = $street;
            $dstrt->value = $district;
            $lgt->value = $longitude;
            $ltt->value = $latitude;

            $adr->appendChild($num);
            $adr->appendChild($sfx);
            $adr->appendChild($strt);
            $adr->appendChild($dstrt);
            $adr->appendChild($lgt);
            $adr->appendChild($ltt);

            $ind = $doc->createElement('indicator');
            $rad = $doc->createAttribute('radius');
            $rad->value = 100;
            $ind->appendChild($rad);

            $text = $doc->createTextNode($indic100);
            $ind = $adr->appendChild($ind);
            $ind->appendChild($text);

            $ind2 = $doc->createElement('indicator');
            $rad2 = $doc->createAttribute('radius');
            $rad2->value = 200;
            $ind2->appendChild($rad2);

            $text2 = $doc->createTextNode($indic200);
            $ind2 = $adr->appendChild($ind2);
            $ind2->appendChild($text2);

            $ind3 = $doc->createElement('indicator');
            $rad3 = $doc->createAttribute('radius');
            $rad3->value = 500;
            $ind3->appendChild($rad3);

            $text3 = $doc->createTextNode($indic500);
            $ind3 = $adr->appendChild($ind3);
            $ind3->appendChild($text3);

            $adr = $root->appendChild($adr);

            return $doc;
    }

    /**
     * Valide le fichier xml
     * @param doc Le document xml
     * @param string Chemin vers le fichier xsd
     * @return Boolean True si valide, false sinon
     */
    function validate($doc, $path) {
        if(!$doc->schemaValidate($path)) {
            print 'DOMDocument::schemaValidate() Generated Errors!</n>';
            return false;
        } else {
            return true;
        }
    }

    /**
     * Sauvegarde le fichier xml
     * @param doc Le document xml
     * @param string Chemin de sauvegarde du fichier xml
     */
    function saveXMLDocument($doc, $path){
        $doc->save($path);
    }
?>