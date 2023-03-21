<?php

// src/DataFixtures/AppFixtures.php
namespace App\DataFixtures;

use App\Entity\Post;
use App\Entity\SiteUser;
use App\Entity\Photo;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Validator\Constraints\DateTime;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $user = new SiteUser();
        $user->setLogin('user '."1");
        $user->setEmail('user_'."1".'@example.com');
        $user->setPassword('pwd____'."1");
        $user->setPhone('+89001239'."1");
        $manager->persist($user);
        $post = new Post();
        $post->setSiteUser($user);
        // $date = new \DateTime();
        $post->setDate(new \DateTime());
        $manager->persist($post);
        $manager->flush();
        // create 20 obj! Bam!
        for ($i = 0; $i < 30; $i++) {
            $photo = new Photo();
            $photo->setPost($post);
            $photo->setName('photo_'.$i);
            $photo->setPath('img/imleedh-ali-Uf-_p8zZiT8-unsplash.jpg');
            $photo->setFormat('jpg');
            $manager->persist($photo);
            $manager->flush();
        }
    }
}