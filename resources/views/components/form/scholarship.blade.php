<div class="{{ $class }}" id="{{ $id }}">
    <!-- Smile, breathe, and go slowly. - Thich Nhat Hanh -->
    <label class="mb-3 font-normal text-lg text-gray-700 dark:text-gray-400">
        Are you eligible for a need-based scholarship? <span class="text-red-400">*</span>
    </label>
    <select name="scholarship" id="scholarship" class="w-full text-xl border-0 border-b-2 border-gray-500 focus:outline-0 focus:ring-0 px-0">
        <option value="yes">Yes</option>
        <option value="no" selected>No</option>
    </select>
    <small class="alert text-red-500 text-md hidden">Please choose in above field!</small>
</div>