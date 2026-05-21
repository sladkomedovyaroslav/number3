<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Лабораторная работа №3</title>

    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">

    <h1>Анкета пользователя</h1>

    <p class="author">
        Выполнил: Сладкомедов Ярослав, ПМИ 23
    </p>

    <?php if (!empty($successMessage)): ?>

        <div class="success">
            <?= htmlspecialchars($successMessage) ?>
        </div>

    <?php endif; ?>

    <?php if (!empty($formErrors)): ?>

        <div class="errors">

            <ul>

                <?php foreach ($formErrors as $error): ?>

                    <li><?= htmlspecialchars($error) ?></li>

                <?php endforeach; ?>

            </ul>

        </div>

    <?php endif; ?>

    <form method="POST" action="">

        <label for="full_name">ФИО</label>

        <input
            type="text"
            id="full_name"
            name="full_name"
            required
        >

        <label for="phone">Телефон</label>

        <input
            type="tel"
            id="phone"
            name="phone"
            required
        >

        <label for="email">E-mail</label>

        <input
            type="email"
            id="email"
            name="email"
            required
        >

        <label for="birth_date">Дата рождения</label>

        <input
            type="date"
            id="birth_date"
            name="birth_date"
            required
        >

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

        <label for="languages">
            Любимые языки программирования
        </label>

        <select
            id="languages"
            name="languages[]"
            multiple
            required
        >

            <?php foreach ($languages as $language): ?>

                <option value="<?= $language['id'] ?>">

                    <?= htmlspecialchars($language['name']) ?>

                </option>

            <?php endforeach; ?>

        </select>

        <label for="biography">Биография</label>

        <textarea
            id="biography"
            name="biography"
            rows="6"
        ></textarea>

        <div class="checkbox">

            <label>

                <input
                    type="checkbox"
                    name="agreement"
                >

                С контрактом ознакомлен(а)

            </label>

        </div>

        <button type="submit">

            Сохранить

        </button>

    </form>

    <div class="links">

        <a href="view.php">

            Просмотреть анкеты

        </a>

    </div>

</div>

</body>
</html>