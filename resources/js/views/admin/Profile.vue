<template>
    <div class="profile-container">
        <h2>Profile</h2>
        <form @submit.prevent="updateProfile" class="profile-form">
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" v-model="email" required />
            </div>
            <div class="form-group">
                <label for="currentPassword">Current Password:</label>
                <input type="password" id="currentPassword" v-model="currentPassword" required />
            </div>
            <div class="form-group">
                <label for="newPassword">New Password:</label>
                <input type="password" id="newPassword" v-model="newPassword" required />
            </div>
            <div class="form-group">
                <label for="confirmNewPassword">Confirm New Password:</label>
                <input type="password" id="confirmNewPassword" v-model="confirmNewPassword" required />
            </div>
            <button type="submit" class="btn">Update Profile</button>
        </form>
    </div>
</template>

<script>
export default {
    name: "Profile",
    data() {
        return {
            email: "",
            currentPassword: "",
            newPassword: "",
            confirmNewPassword: ""
        };
    },
    methods: {
        async fetchProfile() {
            try {
                const response = await fetch('/api/profile');
                const data = await response.json();
                this.email = data.email;
            } catch (error) {
                console.error('An error occurred while fetching profile data.');
            }
        },
        async updateProfile() {
            if (this.newPassword !== this.confirmNewPassword) {
                alert('New passwords do not match.');
                return;
            }

            try {
                const response = await fetch('/api/profile', {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        email: this.email,
                        currentPassword: this.currentPassword,
                        newPassword: this.newPassword
                    })
                });
                const result = await response.json();
                if (result.success) {
                    alert('Profile updated successfully!');
                } else {
                    alert('Failed to update profile.');
                }
            } catch (error) {
                alert('An error occurred while updating your profile.');
            }
        }
    },
    mounted() {
        this.fetchProfile();
    }
};
</script>

<style scoped>
.profile-container {
    max-width: 400px;
    margin: 2rem auto;
    padding: 2rem;
    background: #ffffff;
    border-radius: 10px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    text-align: center;
    transition: all 0.3s ease;
}

.profile-container:hover {
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
}

.profile-container h2 {
    margin-bottom: 1.5rem;
    font-size: 2rem;
    color: #333333;
    text-transform: uppercase;
    letter-spacing: 1.5px;
}

.profile-form {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.form-group {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
}

label {
    margin-bottom: 0.5rem;
    font-weight: 700;
    color: #555555;
    text-transform: uppercase;
    letter-spacing: 1px;
}

input {
    width: 100%;
    padding: 0.75rem;
    border: 1px solid #dddddd;
    border-radius: 5px;
    font-size: 1rem;
    color: #333333;
    transition: border-color 0.3s ease, box-shadow 0.3s ease;
}

input:focus {
    border-color: #007bff;
    box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
    outline: none;
}

.btn {
    padding: 0.75rem 1.5rem;
    background: linear-gradient(135deg, #007bff, #0056b3);
    color: white;
    border: none;
    border-radius: 5px;
    font-size: 1rem;
    font-weight: bold;
    cursor: pointer;
    transition: background 0.3s ease, transform 0.3s ease;
}

.btn:hover {
    background: linear-gradient(135deg, #0056b3, #003f7f);
    transform: translateY(-2px);
}

.btn:active {
    background: linear-gradient(135deg, #004080, #002d5f);
    transform: translateY(0);
}
</style>
