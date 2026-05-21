<?php

    <h1>Сохраненные анкеты</h1>

    <?php if (empty($applications)): ?>

        <p>Анкет пока нет.</p>

    <?php else: ?>

    <table>

        <tr>
            <th>ID</th>
            <th>ФИО</th>
            <th>Телефон</th>
            <th>Email</th>
            <th>Дата рождения</th>
            <th>Пол</th>
            <th>Биография</th>
            <th>Согласие</th>
            <th>Языки</th>
        </tr>

        <?php foreach($applications as $app): ?>

        <tr>

            <td><?= htmlspecialchars($app['id']) ?></td>

            <td><?= htmlspecialchars($app['full_name']) ?></td>

            <td><?= htmlspecialchars($app['phone']) ?></td>

            <td><?= htmlspecialchars($app['email']) ?></td>

            <td><?= htmlspecialchars($app['birth_date']) ?></td>

            <td>
                <?= $app['gender'] === 'male' ? 'Мужской' : 'Женский' ?>
            </td>

            <td><?= nl2br(htmlspecialchars($app['biography'])) ?></td>

            <td>
                <?= $app['agreement'] ? 'Да' : 'Нет' ?>
            </td>

            <td><?= htmlspecialchars($app['languages']) ?></td>

        </tr>

        <?php endforeach; ?>

    </table>

    <?php endif; ?>

    <div class="links">
        <a href="index.php">Вернуться к форме</a>
    </div>

</div>

</body>
</html>
