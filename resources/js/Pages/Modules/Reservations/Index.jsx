import React from 'react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, usePage } from '@inertiajs/react';
import { Transition } from '@headlessui/react';

export default function IndexReservation({ auth, reservations, flash }) {
    return (
        <AuthenticatedLayout
            user={auth.user}
            header={<h2 className="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Reservations</h2>}
        >
            <Head title="Reservations" />

            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                    <div className="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                        <Transition
                            show={flash}
                        >
                            <p className="text-sm text-gray-600 dark:text-gray-400">Reservation created successfully!</p>
                        </Transition>

                        <div className="overflow-x-auto">
                            <table className="min-w-full bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100">
                                <thead>
                                    <tr>
                                        <th className="py-2 px-4 border-b dark:border-gray-700">Location</th>
                                        <th className="py-2 px-4 border-b dark:border-gray-700">Start Date</th>
                                        <th className="py-2 px-4 border-b dark:border-gray-700">End Date</th>
                                        <th className="py-2 px-4 border-b dark:border-gray-700">Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                {reservations.map((reservation) => (
                                    <tr key={reservation.id}>
                                        <td className="py-2 px-4 border-b dark:border-gray-700">{reservation.location.name}</td>
                                        <td className="py-2 px-4 border-b dark:border-gray-700">{reservation.start_date}</td>
                                        <td className="py-2 px-4 border-b dark:border-gray-700">{reservation.end_date}</td>
                                        <td className="py-2 px-4 border-b dark:border-gray-700">{reservation.cost.toFixed(2)}</td>
                                    </tr>
                                ))}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
