@props(['comment' => null, 'jobid' => null])
<div class="textarea-container my-2">
    @if (isset($comment))
        {{--  SHOW +/- EDIT OLD COMMENTS --}}
        <?php $isAuthurized = isset(Auth::user()->candidate) && $comment?->candidate_id == Auth::user()->candidate->id; ?>
        @if (!$isAuthurized)
            {{-- Only Show --}}
            <textarea class="myTextarea form-control" disabled rows="3" cols="10">{{ $comment?->body }}</textarea>
            <span class="by-you"> {{ $comment->candidate->user->name }} </span>
        @else
            {{-- Show & EDIT & DELETE --}}
            <form action="{{ route('comment.update', $comment?->id) }}" method="post">
                @csrf
                @method('PATCH')
                <textarea id="myTextarea-{{ $comment?->id }}" name="body" disabled class="form-control" rows="3"
                    cols="10">{{ $comment?->body }}</textarea>
            </form>
            <div class="dropdown more-options">
                <button class="btn btn-link dropdown-toggle" type="button" id="dropdownMenuButton"
                    data-bs-toggle="dropdown" aria-expanded="false">
                </button>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                    {{-- <li><a class="dropdown-item" href="#">Report</a></li> --}}
                    <li><button class="dropdown-item" onclick="edit('myTextarea-' + {{ $comment?->id }})">Edit</button>
                    </li>
                    <form action="{{ route('comment.destroy', $comment?->id) }}" method="post">
                        @csrf
                        @method('DELETE')
                        <li><button type="submit" class="dropdown-item">Delete</button></li>
                    </form>
                </ul>
            </div>
            <span class="by-you coprimary"> {{ $comment->candidate->user->name }} </span>
        @endif
    @elseif (isset(Auth::user()->candidate))
        {{--  ADD NEW COMMENT if user is candidate --}}
        <form action="{{ route('comment.store') }}" method="post">
            @csrf
            <input type="hidden" name="job_post_id" value="{{ $jobid }}">
            <textarea class="myTextarea form-control" name="body" placeholder="Add comment for this job" rows="3"
                cols="10"></textarea>
            <button type="submit" class="btn btn-primary m-3 px-5">Save</button>
        </form>

    @endif
</div>

<script>
    function edit($id) {
        const saveBtn = document.createElement('button');
        saveBtn.type = 'submit';
        saveBtn.innerHTML = 'Update';
        saveBtn.classList.add('btn', 'btn-primary', 'm-3', 'px-5');
        var txtArea = document.getElementById($id);
        txtArea.removeAttribute('disabled');
        txtArea.focus();
        console.log(txtArea.parentNode);
        txtArea.parentNode.appendChild(saveBtn);
    }
</script>


<style>
    .textarea-container {
        position: relative;
        display: inline-block;
        width: 68%;
        padding-right: 15px;

    }

    .myTextarea {
        width: 100%;
        padding-right: 40px;
        /* Add space for the three dots */
        box-sizing: border-box;
    }

    .more-options {
        position: absolute;
        top: 0px;
        right: 10px;
    }

    .by-you {
        position: absolute;
        bottom: 5px;
        right: 10px;
        padding-right: 10px;
        font-size: 10px !important;
        font-style: italic;
    }
</style>
