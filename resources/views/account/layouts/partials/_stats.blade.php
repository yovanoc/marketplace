<section class="hero is-primary">
    <div class="hero-body">
        <div class="level">
            <div class="level-item has-text-centered">
                <div>
                    <p class="heading">Files</p>
                    <p class="title">{{ $fileCount }}</p>
                </div>
            </div>
            <div class="level-item has-text-centered">
                <div>
                    <p class="heading">Sales</p>
                    <p class="title">{{ $saleCount }}</p>
                </div>
            </div>
            <div class="level-item has-text-centered">
                <div>
                    <p class="heading">Sales this month</p>
                    <p class="title">
                        {{ $thisMonthEarned }}€<br>
                        ({{ $thisMonthEarnedNoCommission }}€)
                    </p>
                </div>
            </div>
            <div class="level-item has-text-centered">
                <div>
                    <p class="heading">Lifetime sales</p>
                    <p class="title">
                        {{ $lifetimeEarned }}€<br>
                        ({{ $lifetimeEarnedNoCommission }}€)
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>
