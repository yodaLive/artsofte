<?php

declare(strict_types=1);

namespace App\Infrastructure\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250404142212 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE brands (id SERIAL NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE cars (id SERIAL NOT NULL, model_id INT NOT NULL, brand_id INT NOT NULL, photo VARCHAR(255) NOT NULL, price NUMERIC(10, 2) NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_95C71D147975B7E7 ON cars (model_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_95C71D1444F5D008 ON cars (brand_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE credit_programs (id SERIAL NOT NULL, name VARCHAR(255) NOT NULL, min_initial_payment NUMERIC(10, 2) NOT NULL, max_monthly_payment NUMERIC(10, 2) NOT NULL, max_loan_term_months INT NOT NULL, interest_rate NUMERIC(10, 1) NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE credit_requests (id SERIAL NOT NULL, car_id INT NOT NULL, credit_program_id INT NOT NULL, initial_payment NUMERIC(10, 2) NOT NULL, loan_term INT NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_D06E6F6FC3C6F69F ON credit_requests (car_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_D06E6F6FCDC0BCB4 ON credit_requests (credit_program_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE models (id SERIAL NOT NULL, brand_id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_E4D6300944F5D008 ON models (brand_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE messenger_messages (id BIGSERIAL NOT NULL, body TEXT NOT NULL, headers TEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, available_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, delivered_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)
        SQL);
        $this->addSql(<<<'SQL'
            COMMENT ON COLUMN messenger_messages.created_at IS '(DC2Type:datetime_immutable)'
        SQL);
        $this->addSql(<<<'SQL'
            COMMENT ON COLUMN messenger_messages.available_at IS '(DC2Type:datetime_immutable)'
        SQL);
        $this->addSql(<<<'SQL'
            COMMENT ON COLUMN messenger_messages.delivered_at IS '(DC2Type:datetime_immutable)'
        SQL);
        $this->addSql(<<<'SQL'
            CREATE OR REPLACE FUNCTION notify_messenger_messages() RETURNS TRIGGER AS $$
                BEGIN
                    PERFORM pg_notify('messenger_messages', NEW.queue_name::text);
                    RETURN NEW;
                END;
            $$ LANGUAGE plpgsql;
        SQL);
        $this->addSql(<<<'SQL'
            DROP TRIGGER IF EXISTS notify_trigger ON messenger_messages;
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TRIGGER notify_trigger AFTER INSERT OR UPDATE ON messenger_messages FOR EACH ROW EXECUTE PROCEDURE notify_messenger_messages();
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE cars ADD CONSTRAINT FK_95C71D147975B7E7 FOREIGN KEY (model_id) REFERENCES models (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE cars ADD CONSTRAINT FK_95C71D1444F5D008 FOREIGN KEY (brand_id) REFERENCES brands (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE credit_requests ADD CONSTRAINT FK_D06E6F6FC3C6F69F FOREIGN KEY (car_id) REFERENCES cars (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE credit_requests ADD CONSTRAINT FK_D06E6F6FCDC0BCB4 FOREIGN KEY (credit_program_id) REFERENCES credit_programs (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE models ADD CONSTRAINT FK_E4D6300944F5D008 FOREIGN KEY (brand_id) REFERENCES brands (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE SCHEMA public
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE cars DROP CONSTRAINT FK_95C71D147975B7E7
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE cars DROP CONSTRAINT FK_95C71D1444F5D008
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE credit_requests DROP CONSTRAINT FK_D06E6F6FC3C6F69F
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE credit_requests DROP CONSTRAINT FK_D06E6F6FCDC0BCB4
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE models DROP CONSTRAINT FK_E4D6300944F5D008
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE brands
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE cars
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE credit_programs
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE credit_requests
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE models
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE messenger_messages
        SQL);
    }
}
