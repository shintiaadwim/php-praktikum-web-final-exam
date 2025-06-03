<!-- Modal toggle -->
<button data-modal-target="crud-modal" data-modal-toggle="crud-modal" class="inline-flex items-center text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
    <svg class="me-1 -ms-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path></svg>Add mata kuliah
</button>

<!-- Main modal -->
<div id="crud-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Create New Mata Kuliah</h3>
                
                <button data-modal-hide="crud-modal"
                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="crud-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <form action="process/matakuliah-add.php" method="POST" class="p-4 md:p-5">
                <div class="grid gap-4 mb-4 grid-cols-2">
                    <div class="col-span-2">
                        <label for="kode_mk" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Kode MK</label>
                        <select name="kode_mk" id="kode_mk"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                            <option selected="">Selcet Kode MK</option>
                            <option value="PASD-TI042105">PASD-TI042105</option>
                            <option value="ASD-TI042101">ASD-TI042101</option>
                            <option value="BD-TI042103">BD-TI042103</option>
                            <option value="SO-TI042102">SO-TI042102</option>
                            <option value="PBD-TI042107">PBD-TI042107</option>
                            <option value="PPWEB-TI042108">PPWEB-TI042108</option>
                            <option value="PWEB-TI042104">PWEB-TI042104</option>
                            <option value="KWN-WN040003">KWN-WN040003</option>
                            <option value="POS-TI042106">POS-TI042106</option>
                            <option value="MTK-WI040002">MTK-WI040002</option>
                        </select>
                    </div>
                    <div class="col-span-2 sm:col-span-1">
                        <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Mata Kuliah</label>
                        <select name="name" id="name"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                            <option selected="">Selcet Matkul</option>
                            <option value="Prak. Alogoritma & Struktur Data">Prak. Alogoritma & Struktur Data</option>
                            <option value="Alogoritma & Struktur Data">Algoritma & Struktur Data</option>
                            <option value="Basis Data">Basis Data</option>
                            <option value="Sistem Operasi">Sistem Operasi</option>
                            <option value="Prak. Basis Data">Prak. Basis Data</option>
                            <option value="Prak. Pemrograman Web">Prak. Pemrograman Web</option>
                            <option value="Pemrograman Web">Pemrograman Web</option>
                            <option value="Kewarganegaraan">Kewarganegaraan</option>
                            <option value="Prak. Sistem Operasi">Prak. Sistem Operasi</option>
                            <option value="Matematika 2">Matematika 2</option>
                        </select>
                    </div>
                    <div class="col-span-2 sm:col-span-1">
                        <label for="room" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Room</label>
                        <select name="room" id="room"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                            <option selected="">Selcet Room</option>
                            <option value="A 301">A 301</option>
                            <option value="B 205">B 205</option>
                            <option value="C 105">C 105</option>
                            <option value="C 106">C 106</option>
                            <option value="C 206">C 206</option>
                            <option value="C 307">C 307</option>
                            <option value="SAW-01.05">SAW-01.05</option>
                        </select>
                    </div>
                </div>
                <button type="submit" class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    <svg class="me-1 -ms-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path></svg>
                    Add
                </button>
            </form>
        </div>
    </div>
</div>

