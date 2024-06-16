<select name="{{ $name ?? 'asd' }}" id="category"
    class="mt-1.5 w-full rounded-lg border-gray-300 text-gray-700 sm:text-sm">
    @foreach ($categories as $category)
        <option value="{{ $category->id }}" {{ $selected == $category->id ? 'selected' : '' }}>
            {{ $category->name }}
        </option>
    @endforeach
</select>
