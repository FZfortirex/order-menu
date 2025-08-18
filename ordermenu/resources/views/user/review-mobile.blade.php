<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="user-id" content="{{ auth()->id() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reviews - {{ $menu->name }}</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
<div class="container mx-auto px-4 py-8">
    <!-- Back & Title -->
    <div class="flex justify-between items-center mb-6">
        <a href="{{ url()->previous() }}" class="flex items-center text-black font-semibold">
            <span class="mr-2">←</span> BACK
        </a>
        <h1 class="text-xl font-bold">Reviews</h1>
    </div>

    <!-- Content -->
    <div class="grid md:grid-cols-2 gap-8">
        <!-- Gambar -->
        <div>
            <img src="/images/{{ $menu->image }}" alt="{{ $menu->name }}" class="w-full rounded-lg shadow">
        </div>

        <!-- Info & Review -->
        <div>
            <h2 class="text-2xl font-bold">{{ $menu->name }}</h2>
            <p class="text-gray-600">{{ $menu->desc }}</p>

            <!-- Rating Summary -->
            <div class="mt-4">
                <p class="text-xl font-semibold">{{ number_format($menu->average_rating, 1) }} dari 5</p>
                <div class="flex items-center text-yellow-400">
                    @for ($i = 1; $i <= 5; $i++)
                        <span class="text-2xl">
                            {{ $i <= $menu->average_rating ? '★' : '☆' }}
                        </span>
                    @endfor
                </div>
                <p class="text-sm text-gray-500 mt-1">{{ $menu->reviews->count() }} Reviews</p>
            </div>

            <!-- Form Review -->
            @if(Auth::check() && !is_numeric(Auth::user()->name))
            <form action="{{ route('reviews.store') }}" method="POST" class="mt-6" id="review-form">
                @csrf
                <input type="hidden" name="menu_id" value="{{ $menu->id }}">

                <label class="block text-sm mb-2 font-medium">Write Your Review</label>
                <div id="star-rating" class="flex space-x-1">
                    @for ($i = 1; $i <= 5; $i++)
                        <svg data-index="{{ $i }}" xmlns="http://www.w3.org/2000/svg"
                             class="w-5 h-5 star text-gray-300 hover:text-yellow-400 transition-colors duration-200 cursor-pointer"
                             fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M12 .587l3.668 7.568 8.332 1.151-6.001 5.849 1.415 8.277L12 18.896l-7.414 4.536 1.415-8.277L.001 9.306l8.332-1.151z"/>
                        </svg>
                    @endfor
                </div>
                <textarea name="comment" class="w-full border rounded p-2 mt-2" rows="3" placeholder="Tulis ulasanmu..." required></textarea>
                <button type="submit"
                        class="mt-3 px-4 py-2 bg-yellow-400 hover:bg-yellow-300 border border-black text-black rounded">
                    Kirim Review
                </button>
            </form>
            @endif

            <!-- List Review -->
            <div class="mt-8 space-y-4" id="review-list">
                @foreach ($menu->reviews as $review)
                    <div class="bg-white p-4 border rounded shadow flex items-start justify-between">
                        <div class="flex">
                            <div class="mr-3">
                                <div class="w-10 h-10 rounded-full bg-gray-300 flex items-center justify-center text-sm font-bold">
                                    {{ strtoupper(substr($review->user->name, 0, 1)) }}
                                </div>
                            </div>
                            <div>
                                <p class="font-semibold">{{ $review->user->name }}</p>
                                <div class="text-yellow-400 text-sm">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <span>{{ $i <= $review->rating ? '★' : '☆' }}</span>
                                    @endfor
                                </div>
                                <p class="text-sm mt-1 text-gray-600">{{ $review->comment }}</p>
                            </div>
                        </div>
                        @if ($user->id === $review->user_id)
                            <button onclick="hapusReview({{ $review->id }}, this)"
                                    class="text-red-500 hover:text-red-700 text-sm mt-2">Hapus</button>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<script>
    let selectedRating = 0;
    const stars = document.querySelectorAll('#star-rating .star');

    stars.forEach((star, i) => {
        star.addEventListener('mouseover', () => {
            stars.forEach((s, j) => {
                s.classList.toggle('text-yellow-400', j <= i);
                s.classList.toggle('text-gray-300', j > i);
            });
        });

        star.addEventListener('mouseout', () => {
            stars.forEach((s, j) => {
                s.classList.toggle('text-yellow-400', j < selectedRating);
                s.classList.toggle('text-gray-300', j >= selectedRating);
            });
        });

        star.addEventListener('click', () => {
            selectedRating = i + 1;
        });
    });

    document.querySelector("#review-form").addEventListener("submit", function (e) {
        e.preventDefault();

        const form = e.target;
        const formData = new FormData(form);

        fetch("{{ route('reviews.store') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
            },
            body: JSON.stringify({
                menu_id: formData.get("menu_id"),
                rating: selectedRating,
                comment: formData.get("comment")
            })
        })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    const reviewList = document.getElementById("review-list");

                    const newReview = document.createElement("div");
                    newReview.className = "bg-white p-4 border rounded shadow flex items-start justify-between";

                    newReview.innerHTML = `
                        <div class="flex">
                            <div class="mr-3">
                                <div class="w-10 h-10 rounded-full bg-gray-300 flex items-center justify-center text-sm font-bold">
                                    ${data.review.user_initial}
                                </div>
                            </div>
                            <div>
                                <p class="font-semibold">${data.review.user_name}</p>
                                <div class="text-yellow-400 text-sm">
                                    ${"★".repeat(data.review.rating)}${"☆".repeat(5 - data.review.rating)}
                                </div>
                                <p class="text-sm mt-1 text-gray-600">${data.review.comment}</p>
                            </div>
                        </div>
                        <button onclick="hapusReview(${data.review.id}, this)"
                                class="text-red-500 hover:text-red-700 text-sm mt-2">Hapus</button>
                    `;

                    reviewList.prepend(newReview);
                    form.reset();
                    selectedRating = 0;

                    stars.forEach((s, j) => {
                        s.classList.remove('text-yellow-400');
                        s.classList.add('text-gray-300');
                    });
                }
            })
            .catch(err => console.error("Request failed", err));
    });

    function hapusReview(id, el) {
        if (!confirm("Yakin mau dihapus?")) return;

        fetch(`/reviews/${id}`, {
            method: "DELETE",
            headers: {
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                "Accept": "application/json"
            }
        })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    el.closest('.bg-white').remove();
                }
            })
            .catch(err => console.error(err));
    }
</script>
</body>
</html>
