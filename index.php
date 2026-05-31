<?php

// Подключаем файл для работы с БД
require 'db.php';

// Получаем подключение к базе данных
$pdo = connectDB();

// Массив для ошибок формы
$formErrors = [];

// Сообщение об успешном сохранении
$successMessage = '';

// Получаем список языков программирования из БД
$stmt = $pdo->query("SELECT * FROM programming_languages ORDER BY name");
$languages = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Проверяем, была ли отправлена форма
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Получаем данные из формы
    $full_name = trim($_POST['full_name'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $birth_date = $_POST['birth_date'] ?? '';
    $gender = $_POST['gender'] ?? '';
    $biography = trim($_POST['biography'] ?? '');

    // true если чекбокс отмечен
    $agreement = isset($_POST['agreement']);

    // Массив выбранных языков
    $selected_languages = $_POST['languages'] ?? [];

    // =========================
    // ВАЛИДАЦИЯ ФИО
    // =========================

    if (empty($full_name)) {

        $formErrors[] = 'Введите ФИО';

    } elseif (!preg_match('/^[а-яА-Яa-zA-Z\s\-]+$/u', $full_name)) {

        $formErrors[] = 'ФИО может содержать только буквы, пробелы и дефисы';
    }

    // =========================
    // ВАЛИДАЦИЯ EMAIL
    // =========================

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $formErrors[] = 'Введите корректный email';
    }

    // =========================
    // ВАЛИДАЦИЯ ТЕЛЕФОНА
    // =========================

    if (!preg_match('/^[\d\s\-\+\(\)]+$/', $phone)) {

        $formErrors[] = 'Некорректный телефон';
    }

    // =========================
    // ВАЛИДАЦИЯ ПОЛА
    // =========================

    $allowed_genders = ['male', 'female'];

    if (!in_array($gender, $allowed_genders)) {

        $formErrors[] = 'Выберите пол';
    }

    // =========================
    // ВАЛИДАЦИЯ ЯЗЫКОВ
    // =========================

    if (empty($selected_languages)) {

        $formErrors[] = 'Выберите хотя бы один язык программирования';
    }

    // =========================
    // ВАЛИДАЦИЯ СОГЛАСИЯ
    // =========================

    if (!$agreement) {

        $formErrors[] = 'Необходимо согласиться с контрактом';
    }

    // =========================
    // СОХРАНЕНИЕ В БАЗУ ДАННЫХ
    // =========================

    if (empty($formErrors)) {

        try {

            // Начинаем транзакцию
            $pdo->beginTransaction();

            // Подготовленный запрос для сохранения анкеты
            $stmt = $pdo->prepare("
                INSERT INTO applications
                (full_name, phone, email, birth_date, gender, biography, agreement)
                VALUES (?, ?, ?, ?, ?, ?, ?)
            ");

            // Выполняем запрос
            $stmt->execute([
                $full_name,
                $phone,
                $email,
                $birth_date,
                $gender,
                $biography,
                $agreement ? 1 : 0
            ]);

            // Получаем ID только что добавленной записи
            $application_id = $pdo->lastInsertId();

            // Подготовленный запрос для связи анкеты и языков
            $stmt = $pdo->prepare("
                INSERT INTO application_languages
                (application_id, language_id)
                VALUES (?, ?)
            ");

            // Сохраняем каждый выбранный язык
            foreach ($selected_languages as $language_id) {

                $stmt->execute([
                    $application_id,
                    $language_id
                ]);
            }

            // Подтверждаем транзакцию
            $pdo->commit();

            $successMessage = 'Данные успешно сохранены!';

        } catch (Exception $e) {

            // Если возникла ошибка — отменяем изменения
            $pdo->rollBack();

            $formErrors[] = 'Ошибка сохранения: ' . $e->getMessage();
        }
    }
}

// Подключаем HTML-форму
include 'form.php';

?>