<!DOCTYPE html>
        </div>
    <?php endif; ?>

    <form method="POST">

        <label>ФИО</label>
        <input type="text" name="full_name" required>

        <label>Телефон</label>
        <input type="tel" name="phone" required>

        <label>Email</label>
        <input type="email" name="email" required>

        <label>Дата рождения</label>
        <input type="date" name="birth_date" required>

        <label>Пол</label>

        <div class="radio-group">
            <label>
                <input type="radio" name="gender" value="male">
                Мужской
            </label>

            <label>
                <input type="radio" name="gender" value="female">
                Женский
            </label>
        </div>

        <label>Любимые языки программирования</label>

        <select name="languages[]" multiple required>

            <?php foreach($languages as $language): ?>

                <option value="<?= $language['id'] ?>">
                    <?= htmlspecialchars($language['name']) ?>
                </option>

            <?php endforeach; ?>

        </select>

        <label>Биография</label>

        <textarea name="biography" rows="6"></textarea>

        <div class="checkbox">
            <label>
                <input type="checkbox" name="agreement">
                С контрактом ознакомлен(а)
            </label>
        </div>

        <button type="submit">Сохранить</button>

    </form>

    <div class="links">
        <a href="view.php">Просмотреть анкеты</a>
    </div>

</div>

</body>
</html>
