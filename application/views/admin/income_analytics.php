<style>
    #box_upcoming .box-card__img {
        padding-top: 100%;
    }

    #box_upcoming .box-card__img .thumbnail {
        position: absolute;
        top: 0;
    }

    #box_finished .box-card__img {
        padding-top: 100%;
    }

    #box_finished .box-card__img .thumbnail {
        position: absolute;
        top: 0;
    }
</style>
<section class="page-heading">
    <div class="left">
        <h2><?= $title ?></h2>
    </div>
</section>
<section class="section">
    <div class="section-heading">
        <div class="left">
            <h3>Pemasukan</h3>
        </div>
        <div class="right">
            <select name="" id="incomeSummary" class="form-control" onchange="income(this.value)">
                <option value="year" selected>Tahunan</option>
                <option value="month">Bulanan</option>
                <option value="week">Mingguan</option>
                <option value="day">Harian</option>
            </select>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="panel">
                <div class="box_pemasukan">
                    <canvas id="chart_year" width="100%"></canvas>
                    <canvas id="chart_month" width="100%"></canvas>
                    <canvas id="chart_week" width="100%"></canvas>
                    <canvas id="chart_day" width="100%"></canvas>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="section">
    <div class="section-heading">
        <div class="left">
            <h3>Asclepedia</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8">
            <div class="panel">
                <select name="" id="year_pedia" onchange="load_chart_asclepedia(this.value)" class="form-control" style="width: 100px;">
                    <?php

                    $year = date('Y');
                    for ($i = $year - 2; $i <= $year + 8; $i++) { ?>
                        <option value="<?= $i ?>" <?= ($i == $year) ? 'selected' : ''  ?>><?= $i ?></option>
                    <?php } ?>
                </select>
                <div class="box_canvas_pedia">
                    <canvas id="chart_asclepedia" width="100%"></canvas>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="section">
    <div class="section-heading">
        <div class="left">
            <h3>Asclepio Go</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8">
            <div class="panel">
                <select name="" id="year_piogo" onchange="load_chart_asclepiogo(this.value)" class="form-control" style="width: 100px;">
                    <?php

                    $year = date('Y');
                    for ($i = $year - 2; $i <= $year + 8; $i++) { ?>
                        <option value="<?= $i ?>" <?= ($i == $year) ? 'selected' : ''  ?>><?= $i ?></option>
                    <?php } ?>
                </select>
                <div class="box_canvas_piogo">
                    <canvas id="chart_asclepiogo" width="100%"></canvas>
                </div>

            </div>
        </div>
    </div>
</section>
<section class="section">
    <div class="section-heading">
        <div class="left">
            <h3>Pemasukan Asclepedia</h3>
        </div>
        <div class="right">
            <select name="" id="asclepediaSummary" class="form-control" onchange="asclepedia(this.value)">
                <option value="year" selected>Tahunan</option>
                <option value="month">Bulanan</option>
                <option value="week">Mingguan</option>
                <option value="day">Harian</option>
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="panel">
                <div class="box_pemasukan_pedia">
                    <canvas id="chart_asclepedia_year" width="100%"></canvas>
                    <canvas id="chart_asclepedia_month" width="100%"></canvas>
                    <canvas id="chart_asclepedia_week" width="100%"></canvas>
                    <canvas id="chart_asclepedia_day" width="100%"></canvas>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="section">
    <div class="section-heading">
        <div class="left">
            <h3>Pemasukan Asclepio Go</h3>
        </div>
        <div class="right">
            <select name="" id="asclepiogoSummary" class="form-control" onchange="asclepiogo(this.value)">
                <option value="year" selected>Tahunan</option>
                <option value="month">Bulanan</option>
                <option value="week">Mingguan</option>
                <option value="day">Harian</option>
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="panel">
                <div class="box_pemasukan_piogo">
                    <canvas id="chart_asclepiogo_year" width="100%"></canvas>
                    <canvas id="chart_asclepiogo_month" width="100%"></canvas>
                    <canvas id="chart_asclepiogo_week" width="100%"></canvas>
                    <canvas id="chart_asclepiogo_day" width="100%"></canvas>
                </div>
            </div>
        </div>
    </div>
</section>