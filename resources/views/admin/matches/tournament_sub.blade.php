<div class="form-group">
    <label for="tournament_sub" class="tournament_sub">大会以下</label>
    <select class="children" name="tournament_sub" class="form-control" @if($tournament_sub === null && old('tournament_sub') === null) disabled @endif>
        <option value="" selected>選択</option>

        @for($i = 1; $i < 35; $i++) 
            <option value="{{ $i }}" data-val="0" @if((old('tournament') === '0' && old('tournament_sub') === "$i") || ($tournament === '0' && $tournament_sub === "$i")) selected @endif>第{{ $i }}節</option>
        @endfor

            <option value="1" data-val="1" @if((old('tournament') === '1' && old('tournament_sub') === "1") || ($tournament === '1' && $tournament_sub === '1')) selected @endif>1回戦</option>
            <option value="2" data-val="1" @if((old('tournament') === '1' && old('tournament_sub') === '2') || ($tournament === '1' && $tournament_sub === '2')) selected @endif>2回戦</option>
            <option value="3" data-val="1" @if((old('tournament') === '1' && old('tournament_sub') === '3') || ($tournament === '1' && $tournament_sub === '3')) selected @endif>3回戦</option>
            <option value="4" data-val="1" @if((old('tournament') === '1' && old('tournament_sub') === '4') || ($tournament === '1' && $tournament_sub === '4')) selected @endif>4回戦</option>
            <option value="5" data-val="1" @if((old('tournament') === '1' && old('tournament_sub') === '5') || ($tournament === '1' && $tournament_sub === '5')) selected @endif>ラウンド16</option>
            <option value="6" data-val="1" @if((old('tournament') === '1' && old('tournament_sub') === '6') || ($tournament === '1' && $tournament_sub === '6')) selected @endif>準々決勝</option>
            <option value="7" data-val="1" @if((old('tournament') === '1' && old('tournament_sub') === '7') || ($tournament === '1' && $tournament_sub === '7')) selected @endif>準決勝</option>
            <option value="8" data-val="1" @if((old('tournament') === '1' && old('tournament_sub') === '8') || ($tournament === '1' && $tournament_sub === '8')) selected @endif>決勝</option>

            <option value="0" data-val="2" @if((old('tournament') === '2' && old('tournament_sub') === '0') || ($tournament === '2' && $tournament_sub === '0')) selected @endif>グループステージ</option>
            <option value="1" data-val="2" @if((old('tournament') === '2' && old('tournament_sub') === '1') || ($tournament === '2' && $tournament_sub === '1')) selected @endif>プレーオフステージ</option>
            <option value="2" data-val="2" @if((old('tournament') === '2' && old('tournament_sub') === '2') || ($tournament === '2' && $tournament_sub === '2')) selected @endif>準々決勝</option>
            <option value="3" data-val="2" @if((old('tournament') === '2' && old('tournament_sub') === '3') || ($tournament === '2' && $tournament_sub === '3')) selected @endif>準決勝</option>
            <option value="4" data-val="2" @if((old('tournament') === '2' && old('tournament_sub') === '4') || ($tournament === '2' && $tournament_sub === '4')) selected @endif>決勝</option>
    </select>
</div>