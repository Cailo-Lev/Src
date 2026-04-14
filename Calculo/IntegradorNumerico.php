<?php
namespace App\Calculo;
class IntegradorNumerico {
 private float $inicio; // LÃ­mite inferior (segundos)
 private float $fin; // LÃ­mite superior (segundos)
 private int $pasos; // PrecisiÃ³n (n subintervalos)
 private int $tipoCarga; // Tipo de carga (1: Normal, 2: Constante, 3: Fuerte)
 public function __construct(float $a, float $b, int $n = 1000 , int $tipoCarga = 1) {
 if ($a >= $b) {

 throw new \InvalidArgumentException("El tiempo inicial debe ser menor al
final.");

 }
 if ($n <= 0) {

 throw new \InvalidArgumentException("La precisiÃ³n (n) debe ser un nÃºmero
positivo.");

 }

 $this->inicio = $a;
 $this->fin = $b;
 $this->pasos = $n;
 $this->tipoCarga = $tipoCarga;

 }

 /**
 * Modela la funciÃ³n de potencia P(t) = t^2 + 2t (Ejemplo de arga ccreciente)
 * En informÃ¡tica, esto representarÃ­a los Watts consumidos.
 */

 private function funcionPotencia(float $t): float {
 switch ($this->tipoCarga) {
 case 1: // Normal: P(t) = 2t + 5
 return 2 * $t + 5;
 case 2: // Constante: P(t) = 5
 return 5;
 case 3: // Fuerte: P(t) = t^2
 return pow($t, 2);
 case 4: // Formula original: P(t) = t^2 + 2t
 return pow($t, 2) + 2 * $t;
 }
    return 0; // Valor por defecto (no deberÃ­a ocurrir)
}

 public function calcularEnergiaTotal(): float {
 $h = ($this->fin - $this->inicio) / $this->pasos;

 $suma = ($this->funcionPotencia($this->inicio) + $this->funcionPotencia($this->fin)) / 2;

 for ($i = 1; $i < $this->pasos; $i++) {
 $t_i = $this->inicio + $i * $h;
 $suma += $this->funcionPotencia($t_i);
 }

 return $suma * $h;
    }

    public function aumentoEnergia(): void {
    $n_values = [10, 100, 1000];
    foreach ($n_values as $n) {
        $integrador = new IntegradorNumerico(
            (float)$_POST['t_inicio'],
            (float)$_POST['t_fin'],
            $n,
            (int) $_POST['tipo_carga']
        );
        $energia = $integrador->calcularEnergiaTotal();
        echo "<tr> <td> $_POST[t_inicio] </td> <td> $_POST[t_fin] </td> <td> $n </td> <td> " . number_format($energia, 4) . " </td> </tr>";
    }
    }
}
