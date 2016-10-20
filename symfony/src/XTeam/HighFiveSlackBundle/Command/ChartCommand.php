<?php

namespace XTeam\HighFiveSlackBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\HttpFoundation\Request;


class ChartCommand  extends ContainerAwareCommand
{
    protected $chartDir = '/chart/';

    protected function configure()
    {
        $this
            ->setName('xteam:slack:chart')
            ->setDescription('Generates a chart from last week')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $chartFileName = $this->saveChart();
        $this->getContainer()->get('x_team_slack_messenger.slack.publisher')->publish(
            $this->getContainer()->getParameter('xteam.highfive.publish_channel'),
            str_replace(
                '|chart|',
                $this->getContainer()->getParameter('xteam.highfive.base_url') . $this->chartDir . $chartFileName,
                $this->getContainer()->getParameter('xteam.highfive.message')
            )
        );
    }

    private function saveChart()
    {
        $date = (new \DateTime())->format('Y_m_d');
        $fileName = $date . '.png';
        $filePath = $this->getChartDirectory() . $fileName;

        $fs = new Filesystem();
        $fs->dumpFile($filePath,
            $this->getContainer()
                ->get('x_team_high_five_slack.controller.chart')
                ->showAction(new Request())
                ->getContent());

        return $fileName;
    }

    private function getChartDirectory()
    {
        return $this->getContainer()->getParameter('assetic.write_to') . $this->chartDir;
    }
}
