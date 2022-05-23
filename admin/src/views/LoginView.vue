<template>
    <form class="flex flex-col w-full h-screen items-center justify-center" id="login" v-if="!showUserCreation">
        <div class="flex flex-col w-1/3 bg-white shadow border px-3 py-1.5 space-y-2">
            <div class="flex flex-row w-full justify-center">
                <h3 class="font-bold text-lg">
                    <i class="fa-solid fa-door-open text-blue-500"></i>
                    Login
                </h3>
            </div>
            <div class="flex flex-col">
                <label for="user">
                    <i class="fa-solid fa-at text-blue-500"></i>
                    Email
                </label>
                <input type="email" class="px-3 py-1.5 border rounded-sm outline-none appearance-none focus:border-b-4 focus:border-blue-200" required>
            </div>
            <div class="flex flex-col">
                <label for="user">
                    <i class="fa-solid fa-lock-open text-blue-500"></i>
                    Parola
                </label>
                <input type="password" class="px-3 py-1.5 border rounded-sm outline-none appearance-none focus:border-b-4 focus:border-blue-200" required>
            </div>
            <button type="submit" class="bg-blue-500 rounded-sm text-white px-3 py-1.5 hover:bg-blue-600">
                <i class="fa-solid fa-arrow-right-to-bracket"></i>
                Login
            </button>
            <div class="flex flex-row justify-center">
                <p class="text-sm text-gray-300 italic">sau</p>
            </div>
            <button type="button" class="bg-green-500 text-white px-3 py-1.5 rounded-sm hover:bg-green-600" @click="showUserCreation = !showUserCreation">
                <i class="fa-solid fa-user-plus"></i>
                Creare utilizator
            </button>
        </div>        
    </form>
    <form class="flex flex-col w-full h-screen items-center justify-center" id="create_user" v-if="showUserCreation">
        <div class="flex flex-col w-1/3 bg-white shadow border px-3 py-1.5 space-y-2">
            <div class="flex flex-row w-full justify-center">
                <h3 class="font-bold text-lg">
                    <i class="fa-solid fa-user-plus text-blue-500"></i>
                    Creare utilizator
                </h3>
            </div>
            <div class="flex flex-col">
                <label for="user">
                    <i class="fa-solid fa-at text-blue-500"></i>
                    Email
                </label>
                <input type="email" class="px-3 py-1.5 border rounded-sm outline-none appearance-none focus:border-b-4 focus:border-blue-200" required>
            </div>
            <div class="flex flex-col">
                <label for="password">
                    <i class="fa-solid fa-lock-open text-blue-500"></i>
                    Parola
                </label>
                <input type="password" id="password" class="px-3 py-1.5 border rounded-sm outline-none appearance-none focus:border-b-4 focus:border-blue-200" required>
            </div>
            <div class="flex flex-col">
                <label for="re_password">
                    <i class="fa-solid fa-lock-open text-blue-500"></i>
                    Repeta parola
                </label>
                <input type="password" id="re_password" class="px-3 py-1.5 border rounded-sm outline-none appearance-none focus:border-b-4 focus:border-blue-200" required>
            </div>
            <button type="submit" class="bg-blue-500 rounded-sm text-white px-3 py-1.5 hover:bg-blue-600">
                <i class="fa-solid fa-user-plus"></i>
                Creare utilizator
            </button>
            <div class="flex flex-row justify-center">
                <p class="text-sm text-gray-300 italic">sau</p>
            </div>
            <button type="button" class="bg-green-500 text-white px-3 py-1.5 rounded-sm hover:bg-green-600" @click="showUserCreation = !showUserCreation">
                <i class="fa-solid fa-arrow-right-to-bracket"></i>
                Logare
            </button>
        </div>
    </form>
</template>

<script>
export default {
    name: "LoginView",
    data() {
        return {
            showUserCreation: false,
        }
    }
}
</script>

<style>
#login {
    background-image: url('../assets/images/undraw_secure_login_pdn4.svg');
    background-repeat: no-repeat;
    background-position: bottom right;
}
#create_user {
    background-image: url('../assets/images/undraw_add_user_re_5oib.svg');
    background-repeat: no-repeat;
    background-position: bottom right;
}
</style>