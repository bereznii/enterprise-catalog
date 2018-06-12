<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WorkersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $nameArr = ['Беляев', 'Соболев', 'Громов', 'Никитин', 'Трофимов', 'Фролов', 'Савельев', 'Пономарёв', 'Тихомиров', 'Фуксман', 'Смирнов', 'Михайловский', 'Андрианов', 'Соболь', 'Гончаров', 'Запольский', 'Лавров', 'Логвинов', 'Наумов', 'Филатов'];
        $surnameArr = ['Андрей', 'Демьян', 'Михаил', 'Дмитрий', 'Антон', 'Богдан', 'Вячеслав', 'Глеб', 'Денис', 'Игорь', 'Кирилл', 'Марк', 'Ростислав', 'Сергей', 'Тимофей', 'Николай', 'Матвей', 'Максим', 'Григорий', 'Павел'];
        $lastnameArr = ['Васильевич', 'Андреевич', 'Александрович', 'Артурович', 'Владимирович', 'Викторович', 'Ярославович', 'Георгиевич', 'Леонидович', 'Романович', 'Петрович', 'Сергеевич', 'Антонович', 'Борисович', 'Иванович', 'Ильич', 'Сильвестрович', 'Станиславович', 'Владленович', 'Юрьевич'];
        $positionArr = ['President', 'Second Management Level', 'Third Management Level', 'Fourth Management Level', 'Fifth Management Level', 'Worker'];
        $salaryArr = [500000, 200000, 100000, 80000, 50000, 20000];

        for($i = 0; $i < 50001; $i++) {

            $name = $nameArr[array_rand($nameArr)] . ' ' . $surnameArr[array_rand($surnameArr)] . ' ' . $lastnameArr[array_rand($lastnameArr)];

            if($i == 0) {
                $position = $positionArr[0];
                $salary = $salaryArr[0];
                $supervisor = '0';
            } else if ($i > 0 && $i < 6) {
                $position = $positionArr[1];
                $salary = $salaryArr[1];
                $supervisor = 1;
            } else if ($i > 5 && $i < 27) {
                $position = $positionArr[2];
                $salary = $salaryArr[2];
                $supervisor = random_int(2, 5);
            } else if ($i > 26 && $i < 87) {
                $position = $positionArr[3];
                $salary = $salaryArr[3];
                $supervisor = random_int(6, 26);
            } else if ($i > 86 && $i < 687) {
                $position = $positionArr[4];
                $salary = $salaryArr[4];
                $supervisor = random_int(27, 86);
            } else if ($i > 686){
                $position = $positionArr[5];
                $salary = $salaryArr[5];
                $supervisor = random_int(87, 686);
            }
            
            DB::insert("INSERT INTO workers (name, position, salary, supervisor) VALUES (?, ?, ?, ?)", [$name, $position, $salary, $supervisor]);
        }
    }
}
