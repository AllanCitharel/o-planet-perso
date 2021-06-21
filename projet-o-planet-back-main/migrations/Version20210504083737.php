<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210504083737 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE dump_waste (dump_id INT NOT NULL, waste_id INT NOT NULL, INDEX IDX_33B8C6102AE724B8 (dump_id), INDEX IDX_33B8C610FA6A22C2 (waste_id), PRIMARY KEY(dump_id, waste_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE dump_waste ADD CONSTRAINT FK_33B8C6102AE724B8 FOREIGN KEY (dump_id) REFERENCES dump (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE dump_waste ADD CONSTRAINT FK_33B8C610FA6A22C2 FOREIGN KEY (waste_id) REFERENCES waste (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE dump ADD emergency_id INT NOT NULL, ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE dump ADD CONSTRAINT FK_476C7125D904784C FOREIGN KEY (emergency_id) REFERENCES emergency (id)');
        $this->addSql('ALTER TABLE dump ADD CONSTRAINT FK_476C7125A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_476C7125D904784C ON dump (emergency_id)');
        $this->addSql('CREATE INDEX IDX_476C7125A76ED395 ON dump (user_id)');
        $this->addSql('ALTER TABLE removal ADD dump_id INT NOT NULL');
        $this->addSql('ALTER TABLE removal ADD CONSTRAINT FK_D4DBB74B2AE724B8 FOREIGN KEY (dump_id) REFERENCES dump (id)');
        $this->addSql('CREATE INDEX IDX_D4DBB74B2AE724B8 ON removal (dump_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE dump_waste');
        $this->addSql('ALTER TABLE dump DROP FOREIGN KEY FK_476C7125D904784C');
        $this->addSql('ALTER TABLE dump DROP FOREIGN KEY FK_476C7125A76ED395');
        $this->addSql('DROP INDEX IDX_476C7125D904784C ON dump');
        $this->addSql('DROP INDEX IDX_476C7125A76ED395 ON dump');
        $this->addSql('ALTER TABLE dump DROP emergency_id, DROP user_id');
        $this->addSql('ALTER TABLE removal DROP FOREIGN KEY FK_D4DBB74B2AE724B8');
        $this->addSql('DROP INDEX IDX_D4DBB74B2AE724B8 ON removal');
        $this->addSql('ALTER TABLE removal DROP dump_id');
    }
}
