<?php


class MONTH
{
    public $days = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'];
    private $months = ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'];
    public $month;
    public $year;

    /**
     * @param int $month : Le mois compris entre 1 et 12
     * @param int $year : l'année
     * @throws Exception
     */
    public function __construct(?int $month = null, ?int $year = null)
    {
        if ($month === null || $month < 1 || $month > 12) {
            $month = (int)date('m', time());
        }
        if ($year === null) {
            $year = (int)date('Y', time());
        }
        $this->month = $month;
        $this->year = $year;
    }

    /**
     * renvoie le 1er jour du mois
     * @return DateTime
     */
    public function getStartingDay(): DateTime
    {
        return new DateTime("{$this->year}-{$this->month}-01");
    }

    /**
     * Renvoie le mois en lettre
     * @return string
     */
    public function toString(): string
    {
        return $this->months[$this->month - 1].' '.$this->year;
    }

    /**
     * Renvoie le nombre de semaines dans le mois
     * @return int
     */
    public function getWeeks(): int
    {
        $start  = $this->getstartingDay();
        $end  = (clone $start)->modify('+1 month -1 day');
        $weeks = (int)$end->format('W') - (int)$start->format('W') + 1;
        if ($weeks < 0) {
            $weeks = (int)$end->format('W');
        }
        return $weeks;
    }

    /**
     * Le jour est-il dans le mois en cours
     * @param DateTime $date
     * @return bool
     */
    public function withInMonth(DateTime $date): bool
    {
        return $this->getStartingDay()->format('Y-m') === $date->format('Y-m');
    }

    /**
     * revoie le mois suivant
     * @return MONTH
     * @throws Exception
     */
    public function nextMonth(): MONTH
    {
        $month = $this->month + 1;
        $year = $this->year;
        if ($month > 12) {
            $month = 1;
            $year++;
        }
        return new MONTH($month, $year);
    }

    /**
     * renvoie le mois précédent
     * @return MONTH
     * @throws Exception
     */
    public function previousMonth(): MONTH
    {
        $month = $this->month - 1;
        $year = $this->year;
        if ($month < 1) {
            $month = 12;
            $year--;
        }
        return new MONTH($month, $year);
    }

    public function holydays($annee): array
    {
        return array(
            $annee.'-01-01',
            $annee.'-05-01',
            $annee.'-08-07',
            $annee.'-08-15',
            $annee.'-11-01',
            $annee.'-11-15',
            $annee.'-12-25'
        );
    }
}
