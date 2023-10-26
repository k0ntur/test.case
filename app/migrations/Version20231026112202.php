<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231026112202 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE country_tax (country VARCHAR(255) NOT NULL, tax INT NOT NULL, tax_num_format VARCHAR(255) NOT NULL, PRIMARY KEY(country))');
        $this->addSql('CREATE TABLE coupons (id SERIAL NOT NULL, discount INT NOT NULL, code VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE products (id SERIAL NOT NULL, name VARCHAR(255) NOT NULL, price INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE purchases (id SERIAL NOT NULL, product_id INT NOT NULL, sum INT NOT NULL, tax_number VARCHAR(255) NOT NULL, tax_rate INT NOT NULL, coupon_code VARCHAR(255) DEFAULT NULL, coupon_discount INT DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, payment_processor VARCHAR(255) NOT NULL, payment_status VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_AA6431FE4584665A ON purchases (product_id)');
        $this->addSql('ALTER TABLE purchases ADD CONSTRAINT FK_AA6431FE4584665A FOREIGN KEY (product_id) REFERENCES products (id) ON DELETE RESTRICT NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE purchases DROP CONSTRAINT FK_AA6431FE4584665A');
        $this->addSql('DROP TABLE country_tax');
        $this->addSql('DROP TABLE coupons');
        $this->addSql('DROP TABLE products');
        $this->addSql('DROP TABLE purchases');
    }
}
