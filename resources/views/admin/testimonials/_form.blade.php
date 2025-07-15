<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <!-- Nama Pelanggan -->
    <div>
        <label for="user_id" class="block text-sm font-medium text-gray-700 mb-1">Nama Pelanggan *</label>
        <select name="user_id" id="user_id"
            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
            required>
            <option value="">-- Pilih Member --</option>
            @foreach ($members as $member)
                <option value="{{ $member->id }}"
                    {{ old('user_id', $testimonial->user_id ?? null) == $member->id ? 'selected' : '' }}>
                    {{ $member->name }}
                </option>
            @endforeach
        </select>
        @error('user_id')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Pekerjaan -->
    <div>
        <label for="customer_job" class="block text-sm font-medium text-gray-700 mb-1">Pekerjaan</label>
        <input type="text" name="customer_job" id="customer_job"
            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
            value="{{ old('customer_job', $testimonial->customer_job ?? '') }}">
        @error('customer_job')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Rating -->
    <div>
        <label for="rating" class="block text-sm font-medium text-gray-700 mb-1">Rating *</label>
        <div class="flex items-center space-x-2">
            <select name="rating" id="rating"
                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                required>
                @for ($i = 1; $i <= 5; $i++)
                    <option value="{{ $i }}"
                        {{ old('rating', $testimonial->rating ?? null) == $i ? 'selected' : '' }}>
                        {{ $i }} Bintang
                    </option>
                @endfor
            </select>
            <div class="flex text-yellow-400">
                @for ($i = 1; $i <= 5; $i++)
                    <svg class="w-5 h-5"
                        fill="{{ $i <= old('rating', $testimonial->rating ?? 0) ? 'currentColor' : 'none' }}"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z">
                        </path>
                    </svg>
                @endfor
            </div>
        </div>
        @error('rating')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Foto Pelanggan -->
    <div>
        <label for="customer_image" class="block text-sm font-medium text-gray-700 mb-1">Foto Pelanggan</label>
        <div class="flex items-center space-x-4">
            <div class="flex-1">
                <input type="file" name="customer_image" id="customer_image"
                    class="block w-full text-sm text-gray-500
                              file:mr-4 file:py-2 file:px-4
                              file:rounded-md file:border-0
                              file:text-sm file:font-semibold
                              file:bg-blue-50 file:text-blue-700
                              hover:file:bg-blue-100">
            </div>
            @if (isset($testimonial) && $testimonial->customer_image)
                <div class="flex-shrink-0">
                    <img src="{{ Storage::url($testimonial->customer_image) }}"
                        class="h-16 w-16 object-cover rounded-full border-2 border-gray-200">
                </div>
            @endif
        </div>
        @error('customer_image')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Komentar -->
    <div class="md:col-span-2">
        <label for="comment" class="block text-sm font-medium text-gray-700 mb-1">Komentar *</label>
        <textarea name="comment" id="comment" rows="4"
            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
            required>{{ old('comment', $testimonial->comment ?? '') }}</textarea>
        @error('comment')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Tampilkan di Halaman Depan -->
    <div class="md:col-span-2">
        <div class="flex items-center">
            <input type="checkbox" name="is_visible" id="is_visible"
                class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                {{ old('is_visible', $testimonial->is_visible ?? false) ? 'checked' : '' }}>
            <label for="is_visible" class="ml-2 block text-sm text-gray-700">
                Tampilkan di Halaman Depan
            </label>
        </div>
    </div>
</div>

<!-- Tombol Aksi -->
<div class="flex items-center justify-end pt-6 border-t border-gray-200 mt-6">
    <a href="{{ route('testimonials.index') }}"
        class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
        Batal
    </a>
    <button type="submit"
        class="ml-3 inline-flex justify-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
        Simpan Testimoni
    </button>
</div>

<!-- Script untuk menampilkan rating secara dinamis -->
<script>
    document.getElementById('rating').addEventListener('change', function() {
        const rating = parseInt(this.value);
        const stars = document.querySelectorAll('#rating + div svg');

        stars.forEach((star, index) => {
            star.setAttribute('fill', index < rating ? 'currentColor' : 'none');
        });
    });
</script>
