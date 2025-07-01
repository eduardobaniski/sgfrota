
<form action="/login" method="POST">
    @csrf
    <label for="user">Usuário:</label>
    <input type="text" id="name" name="name" required>
    <br>
    <label for="password">Senha:</label>
    <input type="password" id="password" name="password" required>
    <br>
    <button type="submit">Login</button>
</form>
