<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $formErrors[] = 'Введите корректный email';
    }

    if (!preg_match('/^[\\d\\s\\-\\+\\(\\)]+$/', $phone)) {
        $formErrors[] = 'Некорректный телефон';
    }

    $allowed_genders = ['male', 'female'];

    if (!in_array($gender, $allowed_genders)) {
        $formErrors[] = 'Выберите пол';
    }

    if (empty($selected_languages)) {
        $formErrors[] = 'Выберите хотя бы один язык программирования';
    }

    if (!$agreement) {
        $formErrors[] = 'Необходимо согласиться с контрактом';
    }

    if (empty($formErrors)) {

        try {

            $pdo->beginTransaction();

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

?>