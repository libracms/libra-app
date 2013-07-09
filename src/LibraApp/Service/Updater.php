<?php

namespace LibraApp\Service;

use Doctrine\DBAL\DriverManager;
use Libra\Mvc\Service\AbstractEntityManagerProvider;

/**
 * Description of Updater
 *
 * @author duke
 */
class Updater extends AbstractEntityManagerProvider
{
    public function updateIfFromLE035()
    {
        $em = $this->getEntityManager();
        $conn = $em->getConnection();

        //$articles = $em->getRepository('LibraArticle\Entity\Article')->findBy(array('id' => array(5, 16)));
        $articles = $em->getRepository('LibraArticle\Entity\Article')->findAll();

        foreach ($articles as $article) {
            $id = $article->getId();
            $sql = "SELECT params FROM article WHERE id=$id";
            $stmt = $conn->query($sql);
            $params = $stmt->fetchColumn(0);
            $paramsArray = unserialize($params)->toArray();
            //$paramsArrayEncoded = json_encode($paramsArray, JSON_UNESCAPED_UNICODE);
            $article->setParams($paramsArray);
        }

        $em->flush();
    }
}
