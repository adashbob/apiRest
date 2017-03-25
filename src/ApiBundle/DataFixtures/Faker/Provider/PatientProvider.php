<?php

namespace ApiBundle\DataFixtures\Faker\Provider;


class PatientProvider
{
  public function patientFirstNames($id)
  {
    $tables =  array('Aliou', 'Bobo', 'Ousmane', 'Adama', 'Seydina');
    return $tables[$id];
  }

  public function patientLasttNames($id)
  {
    $tables =  array('Ba', 'Diallo', 'Diop', 'Faye', 'Diakhate');
    return $tables[$id];
  }

  public function patientAdresse($id)
  {
    $tables =  array('Fass', 'Mbour', 'Dakar', 'Saint-Louis', 'Sacré Coeur');
    return $tables[$id];
  }

   public function birthDay($id)
   {
      $tables = array('10/01/1989', '20/02/1990', '01/01/1992', '30/12/1987', '09/06/1988', '11/11/1989');
      return $tables[$id];
   }
}