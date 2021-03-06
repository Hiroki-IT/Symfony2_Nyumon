<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityRepository;

/**
 * InquiryRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
#リポジトリクラスに検索メソッドを用意
class InquiryRepository extends \Doctrine\ORM\EntityRepository
{
    #キーワードに一致するお問い合わせ一覧を取得するfindAllByKeyword()を定義
    public function findAllByKeyword($keyword)
    {
        #createQueryBuilder()の返り値を$queryに格納
        $query = $this->createQueryBuilder('i')

            #LIKE検索
            ->where('i.name LIKE :keyword')
            ->orWhere('i.tel LIKE :keyword')
            ->orWhere('i.email LIKE :keyword')
            ->orderBy('i.id', 'DESC')

            #$keywordの前後は何でもよい
            ->setParameters([':keyword' => '%'.$keyword.'%'])
            ->getQuery();

        return new ArrayCollection($query->getResult());
    }

    public function findUnprocessed(){

        #createQueryBuilder()の返り値を$queryに格納
        $query = $this->createQueryBuilder('i')
            ->where('i.processStatus = :processStatus')
            ->orWhere('i.processStatus is null')
            ->orderBy('i.id', 'ASC')
            ->setParameters([':processStatus' => '0'])
            ->getQuery();

        return $query->execute();
    }
}
