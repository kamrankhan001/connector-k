<script setup>
    import InputError from '@/Components/InputError.vue';
    import InputLabel from '@/Components/InputLabel.vue';
    import PrimaryButton from '@/Components/PrimaryButton.vue';
    import TextInput from '@/Components/TextInput.vue';
    import NumberInput from '@/Components/NumberInput.vue';
    import {
        useForm
    } from '@inertiajs/vue3';
    import { ref } from 'vue';

    const props = defineProps({
        userProfile: {
            type: Object
        },
    });

    // Create the form data object with all profile fields
    const form = useForm({
        university: props.userProfile?.university || '',
        area: props.userProfile?.area || '',
        city: props.userProfile?.city || '',
        country: props.userProfile?.country || '',
        hobbies: props.userProfile?.hobbies || '',
        occupation: props.userProfile?.occupation || '',
        age: props.userProfile?.age || '',
        education: props.userProfile?.education || '',
        language: props.userProfile?.language || '',
        skills: props.userProfile?.skills || '',
        gender: props.userProfile?.gender || '',
        image: null,
    });

    // Add a method to handle image selection
    const imageInput = ref(null);

    // Handle form submission
    const submitForm = () => {
        const method = props.userProfile ? 'put' : 'post';
        const routeName = props.userProfile ?
            route('profile.save', props.userProfile.id) :
            route('profile.save');

        form[method](routeName, {
            onSuccess: () => {
                alert('Profile saved successfully!');
            },
            onError: (errors) => {
                console.error(errors);
                alert('An error occurred. Please check your input.');
            },
            onFinish: () => {
                console.log('Request finished');
            },
        });
    };
</script>

<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900">
                Matching Information
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                You will see people according to this information.
            </p>
        </header>

        <form @submit.prevent="submitForm" class="mt-6 space-y-6">
            <!-- University Field -->
            <input type="hidden" name="_method" :value="userProfile ? 'PUT' : 'POST'">
            <div>
                <InputLabel for="university" value="University" />
                <TextInput id="university" type="text" class="mt-1 block w-full" v-model="form.university" required
                    autocomplete="university" />
                <InputError class="mt-2" :message="form.errors.university" />
            </div>

            <!-- Area/Neighborhood Field -->
            <div>
                <InputLabel for="area" value="Area/Neighborhood" />
                <TextInput id="area" type="text" class="mt-1 block w-full" v-model="form.area" required
                    autocomplete="area" />
                <InputError class="mt-2" :message="form.errors.area" />
            </div>

            <!-- City Field -->
            <div>
                <InputLabel for="city" value="City" />
                <TextInput id="city" type="text" class="mt-1 block w-full" v-model="form.city" required
                    autocomplete="city" />
                <InputError class="mt-2" :message="form.errors.city" />
            </div>

            <!-- Country Field -->
            <div>
                <InputLabel for="country" value="Country" />
                <TextInput id="country" type="text" class="mt-1 block w-full" v-model="form.country" required
                    autocomplete="country" />
                <InputError class="mt-2" :message="form.errors.country" />
            </div>

            <!-- Hobbies/Interests Field -->
            <div>
                <InputLabel for="hobbies" value="Hobbies/Interests" />
                <TextInput id="hobbies" type="text" class="mt-1 block w-full" v-model="form.hobbies" required
                    autocomplete="hobbies" />
                <InputError class="mt-2" :message="form.errors.hobbies" />
            </div>

            <!-- Occupation/Industry Field -->
            <div>
                <InputLabel for="occupation" value="Occupation/Industry" />
                <TextInput id="occupation" type="text" class="mt-1 block w-full" v-model="form.occupation" required
                    autocomplete="occupation" />
                <InputError class="mt-2" :message="form.errors.occupation" />
            </div>

            <!-- Age Field -->
            <div>
                <InputLabel for="age" value="Age" />
                <NumberInput id="age" type="number" class="mt-1 block w-full" v-model="form.age" required
                    autocomplete="age" />
                <InputError class="mt-2" :message="form.errors.age" />
            </div>

            <!-- Education Level Field -->
            <div>
                <InputLabel for="education" value="Education Level" />
                <TextInput id="education" type="text" class="mt-1 block w-full" v-model="form.education" required
                    autocomplete="education" />
                <InputError class="mt-2" :message="form.errors.education" />
            </div>

            <!-- Language Field -->
            <div>
                <InputLabel for="language" value="Languages" />
                <TextInput id="language" type="text" class="mt-1 block w-full" v-model="form.language" required
                    autocomplete="language" />
                <InputError class="mt-2" :message="form.errors.language" />
            </div>

            <!-- Professional Skills Field -->
            <div>
                <InputLabel for="skills" value="Professional Skills/Certifications" />
                <TextInput id="skills" type="text" class="mt-1 block w-full" v-model="form.skills" required
                    autocomplete="skills" />
                <InputError class="mt-2" :message="form.errors.skills" />
            </div>

            <!-- Gender Field -->
            <div>
                <InputLabel for="gender" value="Gender" />
                <select id="gender" v-model="form.gender" class="mt-1 block w-full">
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                </select>
                <InputError class="mt-2" :message="form.errors.gender" />
            </div>

            <!-- Image Field -->
            <div>
                <InputLabel for="image" value="Profile Image" />
                <input type="file" ref="imageInput" id="image" class="mt-1 block w-full"
                    @change="form.image = imageInput.value.files[0]" />
                <InputError class="mt-2" :message="form.errors.image" />
            </div>

            <!-- Save Button -->
            <div class="flex items-center gap-4">
                <PrimaryButton :disabled="form.processing">Save</PrimaryButton>
                <Transition enter-active-class="transition ease-in-out" enter-from-class="opacity-0"
                    leave-active-class="transition ease-in-out" leave-to-class="opacity-0">
                    <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">
                        Saved.
                    </p>
                </Transition>
            </div>
        </form>
    </section>
</template>
