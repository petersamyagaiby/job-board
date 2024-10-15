@extends("layouts.app")

@section("content")
    <div class="py-5 px-3">
        <form action="{{ route("jobs.update", $job) }}" method="POST">
            @csrf
            @method("PUT")
            <h1 class="text-center pt-5 fw-bolder fftitle codark">Job Edit</h1>
            <div class="d-flex justify-content-end mb-5">
                <a href="{{ route("jobs.show", $job) }}" class="btn bg-warning cowhite fw-bolder fs-4">Back to Post</a>
            </div>
            <div class="mb-3">
                <label for="title" class="form-label">Title:</label>
                <input type="text" class="form-control" id="title" name="title" value="{{ $job->title }}">
                @error("title")
                    <div class="alert alert-danger my-3">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="work_type" class="form-label d-inline">Work Type:</label>
                <select class="form-select d-inline w-auto" id="work_type" name="work_type">
                    @foreach ($workType as $work)
                        <option {{ $work == $job->work_type ? "selected" : "" }} value="{{ $work }}">
                            {{ $work == "onsite" ? "On Site" : ($work == "remote" ? "Remote" : ($work == "hybrid" ? "Hybrid" : "Freelance")) }}
                        </option>
                    @endforeach
                </select>
                @error("work_type")
                    <div class="alert alert-danger my-3">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3 ">
                <label for="city_id" class="">City:</label>
                <select class="form-select d-inline w-auto" id="city_id" name="city_id">
                    @foreach ($cities as $city)
                        <option {{ $city->id == $job->city_id ? "selected" : "" }} value="{{ $city->id }}">
                            {{ $city->name }}</option>
                    @endforeach
                </select>
                @error("city_id")
                    <div class="alert alert-danger my-3">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="vacancies" class="form-label">Vacancies:</label>
                <input type="number" class="form-control d-inline-block w-auto" id="vacancies" name="vacancies" value="{{ $job->vacancies }}">
                @error("vacancies")
                    <div class="alert alert-danger my-3">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label class="me-2">Salary:</label>
                <input type="text" class="form-control w-auto d-inline-block me-3" id="min_salary" name="min_salary" value="{{ $job->min_salary }}">
                <input type="text" class="form-control w-auto d-inline-block me-3" id="max_salary" name="max_salary" value="{{ $job->max_salary }}">
                @error("min_salary")
                    <div class="alert alert-danger my-3">{{ $message }}</div>
                @enderror
                @error("max_salary")
                    <div class="alert alert-danger my-3">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3 ">
                <label for="deadline" class="">Deadline:</label>
                <input type="date" class="form-control w-auto d-inline-block" id="deadline" name="deadline" min="{{ \Carbon\Carbon::now()->format("Y-m-d") }}"
                    max="{{ \Carbon\Carbon::now()->addMonth()->format("Y-m-d") }}" value="{{ \Carbon\Carbon::parse($job->deadline)->format("Y-m-d") }}">
                @error("deadline")
                    <div class="alert alert-danger my-3">{{ $message }}</div>
                @enderror
            </div>

            <hr>
            <div class="row mb-5">
                <div class="col-6">
                    <h4>Categories</h4>
                    <select class="form-select" name="categories[]" multiple size="4" aria-label="Categories">
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->id }}" @if (in_array($cat->id, $job->categories->pluck("id")->toArray())) selected @endif>
                                {{ $cat->name }}</option>
                        @endforeach
                    </select>
                    <h6 class="my-3">Old Selection:</h6>
                    <ul>
                        @foreach ($job->categories as $cat)
                            <li> {{ $cat->name }} </li>
                        @endforeach
                    </ul>
                </div>
                <div class="col-6">
                    <h4>Technologies</h4>
                    <select class="form-select" name="technologis[]" multiple size="4" aria-label="Technologis">
                        @foreach ($technologis as $tec)
                            <option value="{{ $tec->id }}" @if (in_array($tec->id, $job->technologies->pluck("id")->toArray())) selected @endif>
                                {{ $tec->name }}</option>
                        @endforeach
                    </select>
                    <h6 class="my-3">Old Selection:</h6>
                    <ul>
                        @foreach ($job->technologies as $tec)
                            <li> {{ $tec->name }} </li>
                        @endforeach
                    </ul>
                </div>
                <hr>

            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description:</label>
                <textarea class="form-control" id="description" name="description" rows="10">{{ $job->description }}</textarea>
                @error("description")
                    <div class="alert alert-danger my-3">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="qualifications" class="form-label">Qualifications:</label>
                <textarea class="form-control" id="qualifications" name="qualifications" rows="10">{{ $job->qualifications }}</textarea>
                @error("qualifications")
                    <div class="alert alert-danger my-3">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="responsibilities" class="form-label">Responsibilities:</label>
                <textarea class="form-control" id="responsibilities" name="responsibilities" rows="10">{{ $job->responsibilities }}</textarea>
                @error("responsibilities")
                    <div class="alert alert-danger my-3">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="benefits" class="form-label">Benefits:</label>
                <textarea class="form-control" id="benefits" name="benefits" rows="10">{{ $job->benefits }}</textarea>
                @error("benefits")
                    <div class="alert alert-danger my-3">{{ $message }}</div>
                @enderror
            </div>
            <div class="d-flex justify-content-center mt-5">
                <button type="submit" class="btn bgprimary cowhite fw-bolder fs-4">Update Job</button>
            </div>
        </form>
    </div>
@endsection
