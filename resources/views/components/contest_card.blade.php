<article class="card grid xl:grid-cols-5 bg-base-100 shadow-sm hover:shadow-lg transition-all overflow-hidden h-full">
    <figure class="xl:col-span-2 bg-gray-200 rounded-none w-full h-full">
        <img class="object-cover w-full h-full" src="{{ $image }}" alt="{{ $title }}" />
    </figure>
    <div class="card-body xl:col-span-3 p-8 bg-white">
        <div class="mb-5">
            <h4 class="card-title text-2xl font-bold mb-3">
                {{ $title }}
            </h4>
            <p>{{ $description }}</p>
        </div>

        <div class="mb-5">
            <h5 class="font-semibold mb-1">
                Available Categories
            </h5>
            <ul class="list-none list-inside text-sm">
                @foreach ($categories as $category)
                    <li>{{ $category->title }}</li>
                @endforeach
            </ul>
        </div>

        <div class="mb-8">
            <h5 class="font-semibold mb-1">
                Registration
            </h5>
            <p class="inline text-sm text-gray-700">
                {{ $registration_open }} - {{ $registration_close }}
            </p>
        </div>

        <div class="card-actions">
            <a href="{{ $route_detail }}" class="btn btn-outline btn-primary">
                View Detail
                <i class="bi-arrow-right ml-1"></i>
            </a>
        </div>
    </div>
</article>
