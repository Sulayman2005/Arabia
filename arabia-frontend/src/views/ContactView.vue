<script setup>
</script>

<template>
    <div class="contact_view">
        <h1>Contactez-Nous</h1>
        <p>
        Pour toute question, suggestion ou demande d'information, n'hésitez pas à nous contacter.
        Nous sommes là pour vous aider et répondre à vos besoins.
        </p>
    
        <form class="contact-form">
        <div class="form-group">
            <label for="name">Nom :</label>
            <input type="text" id="name" name="name" required />
        </div>
        <div class="form-group">
            <label for="email">Email :</label>
            <input type="email" id="email" name="email" required />
        </div>
        <div class="form-group">
            <label for="message">Message :</label>
            <textarea id="message" name="message" rows="5" required></textarea>
        </div>
        <button type="submit">Envoyer</button>
        </form>
    </div>
</template>

<style scoped>
.contact_view {
    display: flex;
    flex-direction: column;
    max-width: 600px;
    margin: 100px auto;
    padding: 20px;
}
.contact-form {
    display: flex;
    flex-direction: column;
}
.form-group {
    margin-bottom: 15px;
}
.form-group label {
    margin-bottom: 5px;
    font-weight: bold;
}
.form-group input,
.form-group textarea {
    width: 100%;
    padding: 8px;
    box-sizing: border-box;
}
button {
    padding: 10px 15px;
    background-color: #c9a24d;
    color: white;
    border: none;
    cursor: pointer;
}
button:hover {
    background-color: #a6853a;
}
</style>