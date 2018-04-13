<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180408012810 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE addresses CHANGE contactId contactId INT DEFAULT NULL, CHANGE cityId cityId INT DEFAULT NULL');
        $this->addSql('ALTER TABLE cities CHANGE countryId countryId INT DEFAULT NULL');
        $this->addSql('ALTER TABLE email_address CHANGE contactId contactId INT DEFAULT NULL, CHANGE typeId typeId INT DEFAULT NULL');
        $this->addSql('ALTER TABLE phone_numbers CHANGE contactId contactId INT DEFAULT NULL, CHANGE typeId typeId INT DEFAULT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE addresses CHANGE contactId contactId INT DEFAULT NULL, CHANGE cityId cityId INT DEFAULT NULL');
        $this->addSql('ALTER TABLE cities CHANGE countryId countryId INT DEFAULT NULL');
        $this->addSql('ALTER TABLE email_address CHANGE contactId contactId INT DEFAULT NULL, CHANGE typeId typeId INT DEFAULT NULL');
        $this->addSql('ALTER TABLE phone_numbers CHANGE contactId contactId INT DEFAULT NULL, CHANGE typeId typeId INT DEFAULT NULL');
    }
}
