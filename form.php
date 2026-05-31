<!DOCTYPE html>
<html lang="ru">
<head>

    <!-- Кодировка -->
    <meta charset="UTF-8">

    <!-- Адаптация под мобильные устройства -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Лабораторная работа №3</title>

    <!-- Подключение CSS -->
    <link rel="stylesheet" href="style.css">

</head>
<body>

<div class="container">

    <h1>Анкета пользователя</h1>

    <p class="author">
        Выполнил: Сладкомедов Ярослав, ПМИ 23
    </p>

    <!-- Сообщение об успешном сохранении -->

    <?php if (!empty($successMessage)): ?>

        <div class="success">
            <?= htmlspecialchars($successMessage) ?>
        </div>

    <?php endif; ?>

    <!-- Вывод ошибок -->

    <?php if (!empty($formErrors)): ?>

        <div class="errors">

            <ul>

                <?php foreach ($formErrors as $error): ?>

                    <li><?= htmlspecialchars($error) ?></li>

                <?php endforeach; ?>

            </ul>

        </div>

    <?php endif; ?>

    <!-- Начало формы -->

    <form method="POST" action="">

        <!-- ФИО -->

        <label for="full_name">ФИО</label>

        <input
            type="text"
            id="full_name"
            name="full_name"
            required
        >

        <!-- Телефон -->

        <label for="phone">Телефон</label>

        <input
            type="tel"
            id="phone"
            name="phone"
            required
        >

        <!-- Email -->

        <label for="email">E-mail</label>

        <input
            type="email"
            id="email"
            name="email"
            required
        >

        <!-- Дата рождения -->

        <label for="birth_date">Дата рождения</label>

        <input
            type="date"
            id="birth_date"
            name="birth_date"
            required
        >

        <!-- Пол -->

        <label>Пол</label>

        <div class="radio-group">

            <label>

                <input
                    type="radio"
                    name="gender"
                    value="male"
                    required
                >

                Мужской

            </label>

            <label>

                <input
                    type="radio"
                    name="gender"
                    value="female"
                >

                Женский

            </label>

        </div>

        <!-- Любимые языки программирования -->

        <label for="languages">
            Любимые языки программирования
        </label>

        <select
            id="languages"
            name="languages[]"
            multiple
            required
        >

            <!-- Вывод языков из БД -->

            <?php foreach ($languages as $language): ?>

                <option value="<?= $language['id'] ?>">

                    <?= htmlspecialchars($language['name']) ?>

                </option>

            <?php endforeach; ?>

        </select>

        <!-- Биография -->

        <label for="biography">Биография</label>

        <textarea
            id="biography"
            name="biography"
            rows="6"
        ></textarea>

        <!-- Чекбокс согласия -->

        <div class="checkbox">

            <label>

                <input
                    type="checkbox"
                    name="agreement"
                >

                С контрактом ознакомлен(а)

            </label>

        </div>

        <!-- Кнопка отправки -->

        <button type="submit">

            Сохранить

        </button>

    </form>

    <!-- Ссылка на просмотр анкет -->

    <div class="links">

        <a href="view.php">

            Просмотреть анкеты

        </a>

    </div>

</div>

</body>
</html>