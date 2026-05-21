<?php

require 'db.php';

$pdo = connectDB();

$formErrors = [];
$successMessage = '';

$stmt = $pdo->query("SELECT * FROM programming_languages ORDER BY name");
$languages = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $full_name = trim($_POST['full_name'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $birth_date = $_POST['birth_date'] ?? '';
    $gender = $_POST['gender'] ?? '';
    $biography = trim($_POST['biography'] ?? '');
    $agreement = isset($_POST['agreement']);
    $selected_languages = $_POST['languages'] ?? [];

    // ВАЛИДАЦИЯ ФИО
    if (empty($full_name)) {

        $formErrors[] = 'Введите ФИО';

    } elseif (!preg_match('/^[а-яА-Яa-zA-Z\s\-]+$/u', $full_name)) {

        $formErrors[] = 'ФИО может содержать только буквы, пробелы и дефисы';
    }

    // ВАЛИДАЦИЯ EMAIL
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $formErrors[] = 'Введите корректный email';
    }

    // ВАЛИДАЦИЯ ТЕЛЕФОНА
    if (!preg_match('/^[\d\s\-\+\(\)]+$/', $phone)) {

        $formErrors[] = 'Некорректный телефон';
    }

    // ВАЛИДАЦИЯ ПОЛА
    $allowed_genders = ['male', 'female'];

    if (!in_array($gender, $allowed_genders)) {

        $formErrors[] = 'Выберите пол';
    }

    // ВАЛИДАЦИЯ ЯЗЫКОВ
    if (empty($selected_languages)) {

        $formErrors[] = 'Выберите хотя бы один язык программирования';
    }

    // ВАЛИДАЦИЯ СОГЛАСИЯ
    if (!$agreement) {

        $formErrors[] = 'Необходимо согласиться с контрактом';
    }

    // СОХРАНЕНИЕ В БД
    if (empty($formErrors)) {

        try {

            $pdo->beginTransaction();

            // СОХРАНЕНИЕ АНКЕТЫ
            $stmt = $pdo->prepare("
                INSERT INTO applications
                (full_name, phone, email, birth_date, gender, biography, agreement)
                VALUES (?, ?, ?, ?, ?, ?, ?)
            ");

            $stmt->execute([
                $full_name,
                $phone,
                $email,
                $birth_date,
                $gender,
                $biography,
                $agreement ? 1 : 0
            ]);

            $application_id = $pdo->lastInsertId();

            // СОХРАНЕНИЕ ЯЗЫКОВ
            $stmt = $pdo->prepare("
                INSERT INTO application_languages
                (application_id, language_id)
                VALUES (?, ?)
            ");

            foreach ($selected_languages as $language_id) {

                $stmt->execute([
                    $application_id,
                    $language_id
                ]);
            }

            $pdo->commit();

            $successMessage = 'Данные успешно сохранены!';

        } catch (Exception $e) {

            $pdo->rollBack();

            $formErrors[] = 'Ошибка сохранения: ' . $e->getMessage();
        }
    }
}

include 'form.php';

?>