<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210504121235 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_removal (user_id INT NOT NULL, removal_id INT NOT NULL, INDEX IDX_8CD6A941A76ED395 (user_id), INDEX IDX_8CD6A941A00B94E6 (removal_id), PRIMARY KEY(user_id, removal_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_removal ADD CONSTRAINT FK_8CD6A941A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_removal ADD CONSTRAINT FK_8CD6A941A00B94E6 FOREIGN KEY (removal_id) REFERENCES removal (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE removal DROP FOREIGN KEY FK_D4DBB74BA76ED395');
        $this->addSql('DROP INDEX IDX_D4DBB74BA76ED395 ON removal');
        $this->addSql('ALTER TABLE removal ADD creator_id INT NOT NULL, DROP user_id');
        $this->addSql('ALTER TABLE removal ADD CONSTRAINT FK_D4DBB74B61220EA6 FOREIGN KEY (creator_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_D4DBB74B61220EA6 ON removal (creator_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE user_removal');
        $this->addSql('ALTER TABLE removal DROP FOREIGN KEY FK_D4DBB74B61220EA6');
        $this->addSql('DROP INDEX IDX_D4DBB74B61220EA6 ON removal');
        $this->addSql('ALTER TABLE removal ADD user_id INT NOT NULL, DROP creator_id');
        $this->addSql('ALTER TABLE removal ADD CONSTRAINT FK_D4DBB74BA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_D4DBB74BA76ED395 ON removal (user_id)');
    }
}
