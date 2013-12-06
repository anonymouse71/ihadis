<?php

namespace Ihadis\Bundle\CoreBundle\Command;

use Doctrine\Common\Util\Debug;
use Ihadis\Bundle\CoreBundle\Entity\Book;
use Ihadis\Bundle\CoreBundle\Entity\Chapter;
use Ihadis\Bundle\CoreBundle\Entity\Hadith;
use Ihadis\Bundle\CoreBundle\Entity\Section;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

class MigrateCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('ihadis:migrate')
            ->setDescription('Migrate content from v1.0.')
            ->setDefinition(array(
                new InputArgument('host', InputArgument::REQUIRED, 'The database host'),
                new InputArgument('user', InputArgument::REQUIRED, 'The database username'),
                new InputArgument('pass', InputArgument::REQUIRED, 'The database password'),
                new InputArgument('name', InputArgument::REQUIRED, 'The database name')
            ))
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln("<info>Content Migration</info>");

        $connectionFactory = $this->getContainer()->get('doctrine.dbal.connection_factory');
        $connection = $connectionFactory->createConnection(array(
            'driver'   => 'pdo_mysql',
            'user'     => $input->getArgument('user'),
            'password' => $input->getArgument('pass'),
            'host'     => $input->getArgument('host'),
            'dbname'   => $input->getArgument('name'),
        ));

        $sql  = 'SELECT * FROM node_flat ORDER BY field_hadith_book_chapter_id';
        $rows = $connection->executeQuery($sql)->fetchAll();

        foreach ($rows as $row) {

            $hadith = $this->saveHadith($row);
            echo $hadith->getId(), PHP_EOL;

        }

    }

    private function getBook($data)
    {
        $book = $this->getContainer()->get('doctrine.orm.entity_manager')
                     ->getRepository('IhadisCoreBundle:Book')
                     ->findOneBy(array('title' => $data['field_hadith_book']));

        if ($book instanceof Book) {
            return $book;
        }

        $book = new Book();
        $book->setTitle($data['field_hadith_book']);

        $this->getContainer()->get('doctrine.orm.entity_manager')->persist($book);
        $this->getContainer()->get('doctrine.orm.entity_manager')->flush();

        return $book;
    }

    private function getChapter($data, $book)
    {
        $chapter = $this->getContainer()->get('doctrine.orm.entity_manager')
                        ->getRepository('IhadisCoreBundle:Chapter')
                        ->findOneBy(array('title' => $data['field_hadith_book_chapter']));

        if ($chapter instanceof Chapter) {
            return $chapter;
        }

        $chapter = new Chapter();
        $chapter->setTitle($data['field_hadith_book_chapter']);
        $chapter->setBook($book);
        $chapter->setNumber($data['field_hadith_book_chapter_id']);

        $this->getContainer()->get('doctrine.orm.entity_manager')->persist($chapter);
        $this->getContainer()->get('doctrine.orm.entity_manager')->flush();

        return $chapter;
    }

    private function getSection($data, $book, $chapter)
    {
        $section = $this->getContainer()->get('doctrine.orm.entity_manager')
                        ->getRepository('IhadisCoreBundle:Section')
                        ->findOneBy(array('title' => $data['field_section_bangla'], 'chapter' => $chapter));

        if ($section instanceof Section) {
            return $section;
        }

        $section = new Section();

        $section->setTitle($data['field_section_bangla']);
        $section->translate('en')->setTitle($data['field_section_english']);
        $section->translate('ar')->setTitle($data['field_section_arabic']);

        $section->setPreface($data['field_additional_text_bangla']);
        $section->translate('en')->setPreface($data['field_additional_text_english']);
        $section->translate('ar')->setPreface($data['field_additional_text_arabic']);

        $section->setBook($book);
        $section->setChapter($chapter);

        $this->getContainer()->get('doctrine.orm.entity_manager')->persist($section);
        $section->mergeNewTranslations();

        $this->getContainer()->get('doctrine.orm.entity_manager')->flush();

        return $section;
    }

    private function saveHadith($data)
    {
        $book = $this->getBook($data);
        $chapter = $this->getChapter($data, $book);
        $section = $this->getSection($data, $book, $chapter);

        $hadith = new Hadith();

        $hadith->setBody($data['field_bangla_hadith_body']);
        $hadith->translate('en')->setBody($data['field_english_hadith_body']);
        $hadith->translate('ar')->setBody($data['field_arabic_hadith_body']);

        $hadith->translate('en')->setReference($data['field_english_hadith_reference']);
        $hadith->translate('ar')->setReference($data['field_arabic_hadith_reference']);

        $hadith->setNote($data['field_bangla_hadith_note']);
        $hadith->setNumberPrimary($data['field_bangla_hadith_num']);
        $hadith->setNumberSecondary($data['field_international_hadith_num']);
        $hadith->setValidity($data['field_validity']);
        $hadith->setScholarReviewed($data['field_scholar_reviewed']);

        $hadith->setBook($book);
        $hadith->setChapter($chapter);
        $hadith->setSection($section);

        $this->getContainer()->get('doctrine.orm.entity_manager')->persist($hadith);
        $hadith->mergeNewTranslations();

        $this->getContainer()->get('doctrine.orm.entity_manager')->flush();

        return $hadith;
    }
}
