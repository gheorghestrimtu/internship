<?php
require_once 'vendor/autoload.php';

class RoboFile extends \Robo\Tasks {
    use \Codeception\Task\MergeReports;
    use \Codeception\Task\SplitTestsByGroups;

    public function parallelSplitTests() {
        $this->taskSplitTestFilesByGroups(3)
            ->projectRoot('.')
            ->testsFrom('tests/acceptance/Portal')
            ->groupsTo('tests/_data/paracept_')
            ->run();
    }

    public function parallelRun($env) {
        $parallel = $this->taskParallelExec();
        for ($i = 1; $i <= 3; $i++) {
            $parallel->process(
                $this->taskCodecept()
                ->suite('acceptance')
                ->env($env)
                ->group("paracept_$i")
                ->xml("_log/$i.xml")
                ->html("_log/$i.html")
                ->tap("_log/$i.tap")
            );
        }
        return $parallel->run();
    }

    public function parallelMergeResults() {
        $this->taskMergeHTMLReports(glob('tests/_output/_log/*.html'))
            ->into('tests/_output/report.html')
            ->run();

        $this->taskMergeXmlReports(glob('tests/_output/_log/*.xml'))
            ->into('tests/_output/report.xml')
            ->run();
    }

    function parallelStaging() {
//        $this->parallelSplitTests();
        $result = $this->parallelRun("staging");
        $this->parallelMergeResults();
        return $result;
    }

}