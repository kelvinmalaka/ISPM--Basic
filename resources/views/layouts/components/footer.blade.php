<footer class="bg-gray-900">
    <div class="container px-12 md:px-18 lg:px-40 mx-auto">
        <section class="py-10">
            <div class="grid lg:grid-cols-3 lg:gap-x-4">
                <div class="mb-10 lg:mb-0">
                    <a href={{ route('home') }}>
                        <div class="flex items-center mb-4">
                            @include('layouts.components.binus-ribbon', [
                                'class' => 'relative',
                                'style' => 'top: -0.5rem',
                            ])

                            <div class="ml-3">
                                <img class="h-24" src="{{ url('img/logo/logo-sm-white.png') }}" alt="SIS Contest" />
                            </div>
                        </div>
                    </a>
                </div>
                <div class="mb-10 lg:mb-0">
                    <h5 class="text-xl font-semibold uppercase text-white">
                        BINUS Anggrek
                    </h5>
                    <div class="text-gray-400 mt-3">
                        <p class="text-lg">
                            Jalan Kebon Jeruk Raya No.27, RT.1/RW.9, Kebon Jeruk, Jakarta Barat, 11530.
                            BINUS University Anggrek.
                        </p>
                    </div>
                </div>
                <div>
                    <h5 class="text-xl font-semibold uppercase text-white">
                        Our Social Media
                    </h5>
                    <div class="text-gray-400 mt-3">
                        <p>
                            Get latest information by following our social media.
                        </p>

                        <ul class="mt-5 flex">
                            <li class="mx-1">
                                <a class="w-20 h-20 bg-white p-3 opacity-80 hover:opacity-100 transition-opacity rounded-sm"
                                    href="http://fb.me/schoolisbinus">
                                    <i class="bi-facebook text-blue-600"></i>
                                </a>
                            </li>
                            <li class="mx-1">
                                <a class="w-20 h-20 bg-white p-3 opacity-80 hover:opacity-100 transition-opacity rounded-sm"
                                    href="https://www.instagram.com/schoolisbinus/">
                                    <i class="bi-instagram text-purple-600"></i>
                                </a>
                            </li>
                            <li class="mx-1">
                                <a class="w-20 h-20 bg-white p-3 opacity-80 hover:opacity-100 transition-opacity rounded-sm"
                                    href="https://www.youtube.com/c/SISBINUSID">
                                    <i class="bi-youtube text-red-600"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <div class="divider divider-neutral h-0 my-0"></div>

        <div class="py-6 font-normal text-center text-gray-400">
            <p>Copyright &copy; 2024 by School of Information Systems - Bina Nusantara University</p>
        </div>
    </div>
</footer>
