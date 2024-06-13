import React from 'react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, useForm } from '@inertiajs/react';
import InputError from '@/Components/InputError';
import InputLabel from '@/Components/InputLabel';
import PrimaryButton from '@/Components/PrimaryButton';
import TextInput from '@/Components/TextInput';
import SelectInput from "@/Components/SelectInput.jsx";

export default function CreateReservation({ auth, locations }) {
    const { data, setData, post, errors, processing } = useForm({
        start_date: new Date().toISOString().slice(0, 10),
        end_date: new Date().toISOString().slice(0, 10),
        location_id: locations.length > 0 ? locations[0].id : '',
    });

    const submit = (e) => {
        e.preventDefault();
        post(route('reservations.store'));
    };

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={<h2 className="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Create Reservation</h2>}
        >
            <Head title="Create Reservation" />

            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                    <div className="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                        <section className="max-w-xl">
                            <header>
                                <h2 className="text-lg font-medium text-gray-900 dark:text-gray-100">Reservation Information</h2>
                                <p className="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                    Fill in the dates and select location to create a reservation.
                                </p>
                            </header>

                            <form onSubmit={submit} className="mt-6 space-y-6">
                                <div>
                                    <InputLabel htmlFor="location_id" value="Localization" />
                                    <SelectInput
                                        id="location_id"
                                        label="Location"
                                        options={locations.map(location => ({
                                            value: location.id,
                                            label: location.name
                                        }))}
                                        value={data.location_id}
                                        onChange={(e) => setData('location_id', e.target.value)}
                                        error={errors.location_id}
                                    />
                                    <InputError className="mt-2" message={errors.location_id}/>
                                </div>

                                <div>
                                    <InputLabel htmlFor="start_date" value="Start Date"/>
                                    <TextInput
                                        id="start_date"
                                        type="date"
                                        className="mt-1 block w-full"
                                        value={data.start_date}
                                        onChange={(e) => setData('start_date', e.target.value)}
                                        required
                                    />
                                    <InputError className="mt-2" message={errors.start_date}/>
                                </div>

                                <div>
                                    <InputLabel htmlFor="end_date" value="End Date"/>
                                    <TextInput
                                        id="end_date"
                                        type="date"
                                        className="mt-1 block w-full"
                                        value={data.end_date}
                                        onChange={(e) => setData('end_date', e.target.value)}
                                        required
                                    />
                                    <InputError className="mt-2" message={errors.end_date}/>
                                </div>

                                <div className="flex items-center gap-4">
                                    <PrimaryButton disabled={processing}>Submit</PrimaryButton>
                                </div>
                            </form>
                        </section>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
