<?php
 
class BankAccount
{
    // Vulnérabilité S2068 : credential en dur
    private string $adminPassword = 'admin1234';
 
    private float $balance;
    private string $owner;
    // Code smell S1481 : variable jamais utilisée
    private int $unusedCounter = 0;
 
    public function __construct(string $owner, float $initialBalance)
    {
        $this->owner = $owner;
        $this->balance = $initialBalance;
    }
 
    // Bug : aucune validation du montant négatif
    public function deposit(float $amount): void
    {
        $this->balance += $amount;
    }
 
    // Bug : pas de vérification du solde disponible
    public function withdraw(float $amount): void
    {
        $this->balance -= $amount;
    }
 
    public function getBalance(): float
    {
        return $this->balance;
    }
 
    // Code smell S108 : exception avalée silencieusement
    public function transfer(BankAccount $target, float $amount): void
    {
        try {
            $this->withdraw($amount);
            $target->deposit($amount);
        } catch (\Exception $e) {
            // rien — SonarCloud détecte S108
        }
    }
 
    // Code smell S1854 : résultat d'un calcul jamais utilisé
    public function computeFee(float $rate): float
    {
        $fee = $this->balance * $rate;
        $fee = 0; // écrasement inutile avant le return
        return $fee;
    }
}
