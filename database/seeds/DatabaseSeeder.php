<?php

use App\Employee;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->fillEmployees();
    }

    public function fillEmployees(){
        Employee::create(['name' => 'Докукина О.И.', 'type' => 'deal']);
        Employee::create(['name' => 'Сапунова Е.Д.', 'type' => 'deal']);
        Employee::create(['name' => 'Звонарева О.А.', 'type' => 'deal']);
        Employee::create(['name' => 'Алескерова С.А.', 'type' => 'deal']);
        Employee::create(['name' => 'Замышляева Т.А.', 'type' => 'deal']);
        Employee::create(['name' => 'Куракина А.В.', 'type' => 'deal']);
        Employee::create(['name' => 'Доморев А.В.', 'type' => 'deal']);
        Employee::create(['name' => 'Вареничева А.А.', 'type' => 'deal']);
        Employee::create(['name' => 'Волк Н.Н.', 'type' => 'deal']);
        Employee::create(['name' => 'Данько О.В.', 'type' => 'deal']);
        Employee::create(['name' => 'Прокофьев А.А.', 'type' => 'deal']);
        Employee::create(['name' => 'Калюжная Н.Н.', 'type' => 'deal']);
        Employee::create(['name' => 'Фоменкова Е.Н.', 'type' => 'deal']);
        Employee::create(['name' => 'Паршина А.В.', 'type' => 'deal']);
        Employee::create(['name' => 'Соломенцева Н.В.', 'type' => 'deal']);
        Employee::create(['name' => 'Чичерина О.А.', 'type' => 'deal']);
        Employee::create(['name' => 'Бабай В.В.', 'type' => 'deal']);
        Employee::create(['name' => 'Маслова Н.В.', 'type' => 'deal']);

        Employee::create(['name' => 'Еременко М.А.', 'type' => 'fixed']);
        Employee::create(['name' => 'Пряжников Р.Ю.', 'type' => 'fixed']);
        Employee::create(['name' => 'Уциева Л.И.', 'type' => 'fixed']);
        Employee::create(['name' => 'Иванчук М.А.', 'type' => 'fixed']);
        Employee::create(['name' => 'Боровлев А.', 'type' => 'fixed']);
        Employee::create(['name' => 'Киршонков В.В.', 'type' => 'fixed']);
        Employee::create(['name' => 'Гурьянова Ю.', 'type' => 'fixed']);

        Employee::create(['name' => 'Володин С.В.', 'type' => 'dayNight']);
        Employee::create(['name' => 'Перелешин Е.С.', 'type' => 'dayNight']);
        Employee::create(['name' => 'Гурьянов Г.Н.', 'type' => 'dayNight']);
        Employee::create(['name' => 'Демин В.И.', 'type' => 'dayNight']);


        Employee::create(['name' => 'Толмачев А.Н.', 'type' => 'security']);
        Employee::create(['name' => 'Балашов С.В.', 'type' => 'security']);
        Employee::create(['name' => 'Лобов А.И.', 'type' => 'security']);
    }
}
